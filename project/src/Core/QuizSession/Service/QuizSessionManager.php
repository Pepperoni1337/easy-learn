<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Service;

use App\Core\Quiz\Model\QuizQuestion;
use App\Core\Quiz\Model\SessionAnswerResult;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionStatus;
use RuntimeException;

final class QuizSessionManager
{
    public function __construct(
        private readonly QuizSessionLevelManager $levelManager,
    ) {
    }

    public function submitAnswer(
        QuizSession $session,
        QuizQuestion $question,
        string $givenAnswer,
    ): SessionAnswerResult {
        $currentLevel = $session->getCurrentLevel() ?? throw new RuntimeException('No current level');

        $levelResult = $this->levelManager->submitAnswer(
            $currentLevel,
            $question,
            $givenAnswer,
        );

        $levelFinished = $levelResult->isLevelFinished;

        $lastLevelNumber = $currentLevel->getLevel();

        if ($levelFinished) {
            $session->removeRemainingLevel($currentLevel);
        }

        $finished = $session->getCurrentLevel() === null;

        if ($finished) {
            $session->setStatus(QuizSessionStatus::FINISHED);
        }

        return new SessionAnswerResult(
            isCorrect: $levelResult->isCorrect,
            correctAnswer: $levelResult->correctAnswer,
            isLevelFinished: $levelFinished,
            lastLevelNumber: $lastLevelNumber,
            isQuizFinished: $finished,
        );
    }
}
