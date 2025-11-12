<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Service;

use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionLevelQuestion;
use App\Core\QuizSession\Model\QuizSessionResult;
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
        QuizSessionLevelQuestion $question,
        string $givenAnswer,
    ): SessionAnswerResult {
        $currentLevel = $session->getCurrentLevel() ?? throw new RuntimeException('No current level');

        $levelResult = $this->levelManager->submitAnswer(
            $currentLevel,
            $question,
            $givenAnswer,
        );

        $levelFinished = $currentLevel->isFinished();

        $progress = $session->getProgress();

        if ($levelFinished) {
            $progress->increaseScore(100);
            $progress->increaseCurrentLevel();
            $session->removeRemainingLevel($currentLevel);
        }

        $finished = $session->getCurrentLevel() === null;

        if ($finished) {
            $session->setStatus(QuizSessionStatus::FINISHED);
            $session->setResult(new QuizSessionResult(
                quiz: $session->getQuiz(),
                session: $session,
                totalScore: $session->getProgress()->getScore(),
                totalTime: 1.04,
                numberOfCorrectAnswers: $progress->getNumberOfCorrectAnswers(),
                numberOfWrongAnswers: $progress->getNumberOfWrongAnswers(),
            ));
        }

        return new SessionAnswerResult(
            isCorrect: $levelResult->isCorrect,
            correctAnswer: $levelResult->correctAnswer,
            isLevelFinished: $levelFinished,
            lastLevelNumber: $currentLevel->getLevel(),
            isQuizFinished: $finished,
        );
    }
}
