<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Service;

use App\Core\Quiz\Model\QuizQuestion;
use App\Core\QuizSession\Model\LevelAnswerResult;
use App\Core\QuizSession\Model\QuizSessionLevel;

final class QuizSessionLevelManager
{
    public function submitAnswer(
        QuizSessionLevel $sessionLevel,
        QuizQuestion $question,
        string $givenAnswer
    ): LevelAnswerResult {
        $correctAnswer = $question->getAnswer();
        $isCorrect = ($correctAnswer === $givenAnswer);

        if ($isCorrect || !$sessionLevel->getQuizSession()->isKeepWronglyAnsweredQuestions()) {
            $sessionLevel->removeRemainingQuestion($question);
        }

        return new LevelAnswerResult(
            isCorrect: $isCorrect,
            correctAnswer: $correctAnswer,
        );
    }
}
