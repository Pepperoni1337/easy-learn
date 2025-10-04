<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Service;

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


    }
}