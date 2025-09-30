<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

use App\Core\Quiz\Model\Quiz;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\Shared\Traits\WithEntityManager;
use App\Core\User\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz/{quiz}/start-session', name: 'app_quiz_session_start')]
final class StartSessionAction extends AbstractController
{
    use WithEntityManager;

    public function __invoke(Quiz $quiz): Response
    {
        $quizSession = new QuizSession(
            $quiz,
            new User(),
            $quiz->getRandomQuestion(),
        );

        $this->entityManager->persist($quizSession);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_quiz_session_get_question', ['quizSession' => $quizSession->getId()]);
    }
}