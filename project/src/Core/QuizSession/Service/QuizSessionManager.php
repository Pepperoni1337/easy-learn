<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Service;

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

    public function submitAnswer(QuizSession $session, string $givenAnswer): SessionAnswerResult
    {
        $currentLevel = $session->getCurrentLevel();

        if ($currentLevel === null) {
            throw new RuntimeException('No current level');
        }

        $levelResult = $this->levelManager->submitAnswer($currentLevel, $givenAnswer);

        $levelFinished = $levelResult->nextQuestion === null;

        $lastLevelNumber = $currentLevel->getLevel();

        if ($levelFinished) {
            $session->removeRemainingLevel($currentLevel);
        }

        if ($session->getCurrentLevel() === null) {
            $session->setStatus(QuizSessionStatus::FINISHED);
        }

        return new SessionAnswerResult(
            isCorrect: $levelResult->isCorrect,
            correctAnswer: $levelResult->correctAnswer,
            isLevelFinished: $levelFinished,
            lastLevelNumber: $lastLevelNumber,
            nextQuestion: $session->getCurrentQuestion(),
        );
    }
}
