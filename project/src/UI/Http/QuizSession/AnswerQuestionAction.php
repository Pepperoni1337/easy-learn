<?php

declare(strict_types=1);

namespace App\UI\Http\QuizSession;

use App\Core\QuizSession\Model\QuizSession;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz-session/{quizSession}/answer-question', name: 'app_quiz_session_answer_question', methods: ['POST'])]
final class AnswerQuestionAction extends AbstractController
{
    public function __invoke(QuizSession $quizSession)
    {
        // TODO: Implement __invoke() method.
    }
}
