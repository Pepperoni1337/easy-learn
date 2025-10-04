<?php

declare(strict_types=1);

namespace App\Core\Quiz\Model;

final class SessionAnswerResult
{
    public function __construct(
        public readonly bool $isCorrect,
        public readonly string $correctAnswer,
        public readonly bool $isLevelFinished,
        public readonly int $lastLevelNumber,
        public readonly bool $isQuizFinished,
    ) {
    }
}
