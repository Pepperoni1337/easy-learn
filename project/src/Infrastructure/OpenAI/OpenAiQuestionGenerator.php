<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAI;

use App\Application\AI\QuestionDto;
use App\Application\AI\QuestionGenerator;
use App\Util\StringUtil;
use Symfony\Component\Serializer\SerializerInterface;

final class OpenAiQuestionGenerator implements QuestionGenerator
{
    public function __construct(
        private readonly OpenAiApiClient $client,
        private readonly SerializerInterface $serializer,
    )
    {
    }

    /**
     * @return array<int, QuestionDto>
     */
    public function generateQuestions(): array
    {
        $prompt = StringUtil::concat(
            'Jsi automat na otázky. ',
            'Vytvoř sérii otázek a odpovědí na téma, které zadává uživatel.',
            'Počet otázek musí být cca 2-3, nikdy ne víc, než 5',
            'Otázky musí být na sobě nezávislé.',
            'Odpověď musí být jedno až dvě slova, málo znaků - například jméno, název. ',
            'Input uživatele: ',
            'Chtěl bych kvíz na postavy z harryho pottera',
        );

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
                                        'minItems' => 2,
                                        'maxItems' => 5,
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
}