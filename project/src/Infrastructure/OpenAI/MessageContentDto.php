<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAI;

final class MessageContentDto
{
    public function __construct(
        public string $type,
        public string $text,
    ) {
    }
}