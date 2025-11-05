<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAI;

use App\Application\AI\QuestionDto;
use App\Application\AI\QuestionGenerator;
use App\Core\Shared\Traits\WithEntityManager;
use App\Infrastructure\OpenAI\Model\QuestionResponseDto;
use Symfony\Component\Serializer\SerializerInterface;

final class OpenAiQuestionGenerator implements QuestionGenerator
{
    use WithEntityManager;

    public function __construct(
        private readonly OpenAiApiClient $client,
        private readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * @return array<int, QuestionDto>
     */
    public function generateQuestions(string $prompt, int $minCount, int $maxCount): array
    {
        $response = $this->client->request(
            'POST',
            '/v1/responses',
            [
                'json' => [
                    'model' => 'gpt-5',
                    'input' => $prompt,

                    // Definice toolu se STRICT schématem
                    'tools' => [[
                        'type' => 'function',
                        'name' => 'qa_list',
                        'description' => 'Generate a list of Q&A items with three wrong answers as distractors for each.',
                        'parameters' => [
                            'type' => 'object',
                            'properties' => [
                                'qa' => [
                                    'type' => 'array',
                                    'minItems' => $minCount,
                                    'maxItems' => $maxCount,
                                    'items' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'question'       => ['type' => 'string'],
                                            'answer'         => ['type' => 'string'],
                                            'wrong_answer1'  => ['type' => 'string'],
                                            'wrong_answer2'  => ['type' => 'string'],
                                            'wrong_answer3'  => ['type' => 'string'],
                                        ],
                                        'required' => ['question', 'answer', 'wrong_answer1', 'wrong_answer2', 'wrong_answer3'],
                                        'additionalProperties' => false
                                    ],
                                ],
                            ],
                            'required' => ['qa'],
                            'additionalProperties' => false
                        ],
                        'strict' => true
                    ]],

                    // Přinuťte model tool zavolat (žádné volné texty)
                    'tool_choice' => [
                        'type' => 'function',
                        'name' => 'qa_list',
                    ],

                    // Můžete klidně nechat vyšší reasoning:
                    'reasoning' => ['effort' => 'medium'], // nebo 'high' – ale viz poznámka níže

                    // Zvyšte limit, ať neskončíte jako 'incomplete/max_output_tokens'
                    'max_output_tokens' => 16000,

                    // (volitelné) jednodušší výstup bez paralelních volání
                    'parallel_tool_calls' => false,
                ],
            ]
        );

        $response = $response->getContent(false);

        $result = $this->serializer->deserialize($response, QuestionResponseDto::class, 'json');

        $questionsDataRaw = $result->output[1]['arguments'];
        $status = $result->output[1]['status'];

        $this->logData($prompt, $questionsDataRaw, $status);

        $test = json_decode($questionsDataRaw, false)->qa;

        $result = [];

        foreach ($test as $item) {
            $result[] = new QuestionDto(
                $item->question,
                $item->answer,
                $item->wrong_answer1,
                $item->wrong_answer2,
                $item->wrong_answer3,
            );
        }

        return $result;
    }

    private function logData(string $prompt, string $questionsDataRaw, string $status): void
    {
        $em = $this->entityManager;
        $conn = $em->getConnection();

        $conn->executeStatement("
            CREATE TABLE IF NOT EXISTS ai_logs (
                id INTEGER PRIMARY KEY AUTO_INCREMENT,
                prompt TEXT NOT NULL,
                response TEXT NOT NULL,
                status VARCHAR(255) NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");

        $conn->executeStatement("
            INSERT INTO ai_logs (prompt, response, status) 
            VALUES (:prompt, :response, :status)
        ", [
                'prompt' => $prompt,
                'response' => $questionsDataRaw,
                'status' => $status,
            ]);
    }
}
