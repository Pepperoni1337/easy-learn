<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAI\Model;

final class QuestionResponseDto
{
    public function __construct(
        public string $id,
        public string $model,
        /**
         * @var array<int, OutputItemDto> $output
         */
        public array $output,
    ) {
    }
}
