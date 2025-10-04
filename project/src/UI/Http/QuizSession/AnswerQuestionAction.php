<?php

declare(strict_types=1);

namespace App\UI\Http\QuizSession;

use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Service\QuizSessionManager;
use App\Core\Shared\Traits\WithEntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz-session/{quizSession}/answer-question', name: 'app_quiz_session_answer_question', methods: ['POST'])]
final class AnswerQuestionAction extends AbstractController
{
    use WithEntityManager;

    public function __construct(
        private readonly QuizSessionManager $manager,
    ) {
    }

    public function __invoke(QuizSession $quizSession, Request $request): Response
    {
        $result = $this->manager->submitAnswer(
            $quizSession,
            (string) $request->get('answer', '')
        );

        $this->entityManager->flush();

        $this->addFlash(
            $result->isCorrect ? 'success' : 'danger',
            $result->isCorrect
                ? sprintf('Správně, odpověď skutečně byla "%s".', $result->correctAnswer)
                : sprintf('Špatně, správná odpověď byla "%s".', $result->correctAnswer)
        );

        if ($result->isLevelFinished) {
            $this->addFlash(
                'success',
                sprintf('Úroveň %s úspěšně dokončena', $result->lastLevelNumber)
            );
        }

        if ($result->nextQuestion === null) {
            $this->addFlash(
                'success',
                sprintf('Kvíz %s úspěšně dokončen', $quizSession->getQuiz()->getTitle())
            );

            return $this->redirectToRoute('app_index');
        }

        return $this->redirectToRoute('app_quiz_session_get_question', [
            'quizSession' => $quizSession->getId(),
        ]);
    }
}
