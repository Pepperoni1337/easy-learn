<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Service;

use App\Core\Quiz\Model\QuizQuestion;
use App\Core\QuizSession\Model\LevelAnswerResult;
use App\Core\QuizSession\Model\QuestionStatus;
use App\Core\QuizSession\Model\QuizSessionLevel;
use App\Core\QuizSession\Model\QuizSessionLevelQuestion;

final class QuizSessionLevelManager
{
    public function submitAnswer(
        QuizSessionLevel $sessionLevel,
        QuizSessionLevelQuestion $question,
        string $givenAnswer
    ): LevelAnswerResult {
        $correctAnswer = $question->getAnswer();
        $isCorrect = ($correctAnswer === $givenAnswer);

        if ($isCorrect || !$sessionLevel->getQuizSession()->getSettings()->isKeepWronglyAnsweredQuestions()) {
            $question->setStatus(QuestionStatus::ANSWERED);
        }

        $progress = $sessionLevel->getQuizSession()->getProgress();
        if ($isCorrect) {
            $progress->increaseScore(10);
            $progress->increaseCurrentStreak();
        } else {
            $progress->resetCurrentStreak();
        }

        return new LevelAnswerResult(
            isCorrect: $isCorrect,
            correctAnswer: $correctAnswer,
        );
    }
}
