<?php

declare(strict_types=1);

namespace App\UI\Http\Shared;

use App\Core\QuizSession\Model\QuizSessionResult;

final class QuizSessionResultOutput
{
    public function __construct(
        public readonly int $totalScore,
        public readonly float $totalTime,
        public readonly int $numberOfCorrectAnswers,
        public readonly int $numberOfWrongAnswers,
        public readonly UserOutput $player,
    ) {
    }

    public static function fromQuizSessionResult(QuizSessionResult $result): self
    {
        return new self(
            $result->getTotalScore(),
            $result->getTotalTime(),
            $result->getNumberOfCorrectAnswers(),
            $result->getNumberOfWrongAnswers(),
            UserOutput::fromUser($result->getSession()->getPlayer()),
        );
    }
}
