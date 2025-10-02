<?php

declare(strict_types=1);

namespace App\UI\Http\QuizSession;

use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionStatus;
use App\Core\Shared\Traits\WithEntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz-session/{quizSession}/answer-question', name: 'app_quiz_session_answer_question', methods: ['POST'])]
final class AnswerQuestionAction extends AbstractController
{
    use WithEntityManager;

    public function __invoke(QuizSession $quizSession, Request $request): Response
    {
        $givenAnswer = (string) $request->get('answer', '');
        $currentQuestion = $quizSession->getCurrentQuestion();
        $correctAnswer = $currentQuestion->getAnswer();
        $isCorrect = ($correctAnswer === $givenAnswer);

        if ($isCorrect) {
            $quizSession->removeRemainingQuestion($currentQuestion);
        }

        $nextQuestion = $quizSession->getRandomRemainingQuestion();

        if ($nextQuestion === null) {
            $quizSession->setStatus(QuizSessionStatus::FINISHED);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                sprintf('Kvíz %s úspěšně dokončen', $quizSession->getQuiz()->getTitle()),
            );

            return $this->redirectToRoute('app_index');
        }

        $quizSession->setCurrentQuestion($nextQuestion);
        $this->entityManager->flush();

        $this->addFlash(
            $isCorrect ? 'success' : 'danger',
            $isCorrect
                ? sprintf('Správně, odpověď skutečně byla "%s".', $correctAnswer)
                : sprintf('Špatně, správná odpověď byla "%s".', $correctAnswer)
        );

        return $this->redirectToRoute('app_quiz_session_get_question', [
            'quizSession' => $quizSession->getId(),
        ]);
    }
}
