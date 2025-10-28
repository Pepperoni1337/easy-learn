<?php

declare(strict_types=1);

namespace App\Application\AI;

final class QuestionDto
{
    public function __construct(
        public string $question,
        public string $answer,
        public string $wrongAnswer1,
        public string $wrongAnswer2,
        public string $wrongAnswer3,
    ) {
    }
}