<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Service;

use App\Core\Quiz\Model\QuizQuestion;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionStatus;
use App\Core\QuizSession\Model\SessionAnswerResult;
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

        $levelFinished = $currentLevel->isFinished();

        $lastLevelNumber = $currentLevel->getLevel();

        if ($levelFinished) {
            $session->removeRemainingLevel($currentLevel);
        }

        $finished = $session->getCurrentLevel() === null;

        if ($finished) {
            $session->setStatus(QuizSessionStatus::FINISHED);
        }

        $progress = $session->getProgress();
        if ($levelResult->isCorrect) {
            $progress->setScore($progress->getScore() + 10);
            ;
        }

        if ($levelFinished) {
            $progress->setCurrentLevel($progress->getCurrentLevel() + 1);
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
