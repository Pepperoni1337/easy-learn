<?php

declare(strict_types=1);

namespace App\Core\Quiz\Model;

final class LevelAnswerResult
{
    public function __construct(
        public readonly bool $isCorrect,
        public readonly string $correctAnswer,
        public readonly ?QuizQuestion $nextQuestion
    ) {
    }
}
