<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAI\Model;

final class MessageContentDto
{
    public function __construct(
        public string $type,
        public string $text,
    ) {
    }
}