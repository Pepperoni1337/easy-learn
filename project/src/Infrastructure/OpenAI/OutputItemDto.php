<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAI;

final class OutputItemDto
{
    public function __construct(
        public string $type,
        public string $status,
        /**
         * @var array<int, MessageContentDto> $content
         */
        public array $content,
        public string $role,
    ) {
    }
}