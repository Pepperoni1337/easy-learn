<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

final class LevelAnswerResult
{
    public function __construct(
        public readonly bool $isCorrect,
        public readonly string $correctAnswer,
    ) {
    }
}
