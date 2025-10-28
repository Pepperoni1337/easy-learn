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
                    'model' => 'gpt-5-nano',
                    'input' => $prompt,
                    'text' => [
                        'format' => [
                            'type' => 'json_schema',
                            'name' => 'qa_list_schema',
                            'strict' => true,
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'qa' => [
                                        'type' => 'array',
                                        'minItems' => $minCount,
                                        'maxItems' => $maxCount,
                                        'items' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'question' => ['type' => 'string'],
                                                'answer'   => ['type' => 'string'],
                                            ],
                                            'required' => ['question', 'answer'],
                                            'additionalProperties' => false
                                        ],
                                    ],
                                ],
                                'required' => ['qa'],
                                'additionalProperties' => false
                            ],
                        ],
                    ],
                ],
            ]
        );

        $response = $response->getContent(false);

        $result = $this->serializer->deserialize($response, QuestionResponseDto::class, 'json');

        $questionsDataRaw = $result->output[1]['content'][0]['text'];

        $this->logData($prompt, $questionsDataRaw);

        $test = json_decode($questionsDataRaw, false)->qa;

        $result = [];

        foreach ($test as $item) {
            $result[] = new QuestionDto(
                $item->question,
                $item->answer,
            );
        }

        return $result;
    }

    private function logData(string $prompt, string $questionsDataRaw): void
    {
        $em = $this->entityManager;
        $conn = $em->getConnection();

        $conn->executeStatement("
            CREATE TABLE IF NOT EXISTS ai_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                prompt TEXT NOT NULL,
                response TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");

        $conn->executeStatement("
            INSERT INTO ai_logs (prompt, response) 
            VALUES (:prompt, :response)
        ", [
                'prompt' => $prompt,
                'response' => $questionsDataRaw,
            ]);
        }
}