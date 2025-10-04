<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Service;

use App\Core\Quiz\Model\LevelAnswerResult;
use App\Core\QuizSession\Model\QuizSessionLevel;
use RuntimeException;

final class QuizSessionLevelManager
{
    public function submitAnswer(QuizSessionLevel $sessionLevel, string $givenAnswer): LevelAnswerResult
    {
        $current = $sessionLevel->getCurrentQuestion() ?? throw new RuntimeException('Current question is null');
        $correctAnswer = $current->getAnswer();
        $isCorrect = ($correctAnswer === $givenAnswer);

        if ($isCorrect) {
            $sessionLevel->removeRemainingQuestion($current);
        }

        return new LevelAnswerResult(
            isCorrect: $isCorrect,
            correctAnswer: $correctAnswer,
            isLevelFinished:  $sessionLevel->getCurrentQuestion() === null,
        );
    }
}
