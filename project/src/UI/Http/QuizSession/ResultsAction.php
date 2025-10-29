<?php

declare(strict_types=1);

namespace App\UI\Http\QuizSession;

use App\Core\QuizSession\Model\QuizSession;
use App\UI\Http\Shared\QuizSessionOutput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz-session/{quizSession}/results', name: 'app_quiz_session_results', methods: ['GET'])]
final class ResultsAction extends AbstractController
{
    public function __invoke(
        QuizSession $quizSession
    ) {
        if (!$quizSession->getStatus()->isFinished()) {
            return $this->redirectToRoute('app_quiz_session_get_question', ['quizSession' => $quizSession->getId()]);
        }

        return $this->render(
            'quiz-session/results.html.twig',
            [
                'quizSession' => QuizSessionOutput::fromQuizSession($quizSession),
            ],
        );
    }
}
