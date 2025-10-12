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
    ) {
    }

    public static function fromQuizSession(QuizSession $quizSession): self
    {
        return new self(
            $quizSession->getId(),
            QuizOutput::fromQuiz($quizSession->getQuiz()),
            UserOutput::fromUser($quizSession->getOwner()),
            $quizSession->getStatus(),
        );
    }
}
