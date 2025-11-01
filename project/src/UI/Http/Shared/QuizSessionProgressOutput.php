<?php

declare(strict_types=1);

namespace App\UI\Http\Shared;

use App\Core\QuizSession\Model\QuizSessionProgress;
use App\Core\Shared\Model\Id;

final class QuizSessionProgressOutput
{
    public function __construct(
        public readonly Id $id,
        public readonly int $currentLevel,
        public readonly int $score,
        public readonly int $currentStreak,
        public readonly int $maxStreak,
    ) {
    }

    public static function fromQuizSessionProgress(QuizSessionProgress $progress): self
    {
        return new self(
            id: $progress->getId(),
            currentLevel: $progress->getCurrentLevel(),
            score: $progress->getScore(),
            currentStreak: $progress->getCurrentStreak(),
            maxStreak: $progress->getMaxStreak(),
        );
    }
}
