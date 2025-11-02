<?php

declare(strict_types=1);

namespace App\UI\Http\Shared;

use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionProgress;
use App\Core\QuizSession\Model\QuizSessionStatus;
use App\Core\Shared\Model\Id;

final class QuizSessionOutput
{
    public function __construct(
        public readonly Id $id,
        public readonly QuizOutput $quiz,
        public readonly UserOutput $player,
        public readonly QuizSessionStatus $status,
        public readonly int $numberOfLevelsAtStart,
        public readonly QuizSessionProgressOutput $progress,
        public readonly ?QuizSessionResultOutput $result,
    ) {
    }

    public static function fromQuizSession(QuizSession $session): self
    {
        return new self(
            id: $session->getId(),
            quiz: QuizOutput::fromQuiz($session->getQuiz()),
            player: UserOutput::fromUser($session->getPlayer()),
            status: $session->getStatus(),
            numberOfLevelsAtStart: $session->getNumberOfLevelsAtStart(),
            progress: QuizSessionProgressOutput::fromQuizSessionProgress($session->getProgress()),
            result: $session->getResult() ? QuizSessionResultOutput::fromQuizSessionResult($session->getResult()) : null,
        );
    }
}
