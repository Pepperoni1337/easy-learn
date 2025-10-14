<?php

declare(strict_types=1);

namespace App\UI\Http\Shared;

use App\Core\QuizSession\Model\QuizSessionLevel;

final class QuizSessionLevelOutput
{
    public function __construct(
        public readonly int $currentQuestionNumber,
        public readonly int $numberOfQuestionsAtStart,
    ) {
    }

    public static function fromQuizSessionLevel(QuizSessionLevel $level): self
    {
        return new self(
            self::resolveCurrentQuestion($level),
            $level->getNumberOfQuestionsAtStart(),
        );
    }

    private static function resolveCurrentQuestion(QuizSessionLevel $level): int
    {
        return 1 + $level->getNumberOfQuestionsAtStart() - $level->getRemainingQuestions()->count();
    }
}