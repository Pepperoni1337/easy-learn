<?php

declare(strict_types=1);

namespace App\UI\Http\QuizSession;

use App\Core\QuizSession\Model\QuizSession;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz-session/{quizSession}/answer-question', name: 'app_quiz_session_answer_question', methods: ['POST'])]
final class AnswerQuestionAction extends AbstractController
{
    public function __invoke(QuizSession $quizSession, Request $request): Response
    {
        $answer = $request->get('answer');

        $correctAnswer = $quizSession->getCurrentQuestion()->getAnswer();
        $result = $correctAnswer === $answer;

        $type = $result ? 'success' : 'danger';
        $message = $result
            ? sprintf('Správně, odpověď skutečně byla "%s".', $correctAnswer)
            : sprintf('Špatně, správná odpověď byla "%s".', $correctAnswer);

        $this->addFlash(
            $type,
            $message,
        );

        return $this->redirectToRoute(
            'app_quiz_session_get_question',
            [
                'quizSession' => $quizSession->getId(),
            ],
        );
    }
}
