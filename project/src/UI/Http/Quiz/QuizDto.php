<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

final class QuizDto
{
    public function __construct(
        public string $name = '',
        public string $prompt = '',
    ) {
    }
}