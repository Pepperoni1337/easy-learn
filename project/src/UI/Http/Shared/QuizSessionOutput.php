<?php

declare(strict_types=1);

namespace App\UI\Http\Shared;

use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionStatus;
use App\Core\Shared\Model\Id;

final class QuizSessionOutput
{
    public function __construct(
        public readonly Id $id,
        public readonly QuizOutput $quiz,
        public readonly UserOutput $owner,
        public readonly QuizSessionStatus $status,
        public readonly int $numberOfLevelsAtStart,
        public readonly int $currentLevelNumber,
        public readonly ?QuizSessionResultOutput $result,
    ) {
    }

    public static function fromQuizSession(QuizSession $session): self
    {
        return new self(
            id: $session->getId(),
            quiz: QuizOutput::fromQuiz($session->getQuiz()),
            owner: UserOutput::fromUser($session->getOwner()),
            status: $session->getStatus(),
            numberOfLevelsAtStart: $session->getNumberOfLevelsAtStart(),
            currentLevelNumber: self::resolveCurrentLevel($session),
            result: $session->getResult() ? QuizSessionResultOutput::fromQuizSessionResult($session->getResult()) : null,
        );
    }

    private static function resolveCurrentLevel(QuizSession $session): int
    {
        return 1 + $session->getNumberOfLevelsAtStart() - $session->getRemainingLevels()->count();
    }
}
