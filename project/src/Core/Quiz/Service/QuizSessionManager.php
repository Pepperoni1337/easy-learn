<?php

declare(strict_types=1);

namespace App\Core\Quiz\Service;

use App\Core\Quiz\Model\AnswerResult;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionStatus;
use App\Core\Shared\Traits\WithEntityManager;

final class QuizSessionManager
{
    use WithEntityManager;

    public function submitAnswer(QuizSession $session, string $givenAnswer): AnswerResult
    {
        $current = $session->getCurrentQuestion();
        $correctAnswer = $current->getAnswer();
        $isCorrect = ($correctAnswer === $givenAnswer);

        if ($isCorrect) {
            $session->removeRemainingQuestion($current);
        }

        $next = $session->getRandomRemainingQuestion();

        if ($next === null) {
            $session->setStatus(QuizSessionStatus::FINISHED);
            $this->entityManager->flush();

            return new AnswerResult(
                isCorrect: $isCorrect,
                correctAnswer: $correctAnswer,
                isFinished: true,
                nextQuestion: null
            );
        }

        $session->setCurrentQuestion($next);
        $this->entityManager->flush();

        return new AnswerResult(
            isCorrect: $isCorrect,
            correctAnswer: $correctAnswer,
            isFinished: false,
            nextQuestion: $next
        );
    }
}