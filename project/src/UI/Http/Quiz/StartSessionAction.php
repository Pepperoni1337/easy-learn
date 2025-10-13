<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

use App\Core\Quiz\Model\Quiz;
use App\Core\QuizSession\Service\QuizSessionFactory;
use App\Core\Shared\Traits\WithEntityManager;
use App\Core\User\Model\User;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz/{quiz}/start-session', name: 'app_quiz_session_start')]
final class StartSessionAction extends AbstractController
{
    use WithEntityManager;

    public function __construct(
        private readonly QuizSessionFactory $quizSessionFactory,
    ) {
    }

    public function __invoke(Quiz $quiz): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new RuntimeException('User is not logged in.');
        }

        $quizSession = $this->quizSessionFactory->createNewSession($quiz, $user);

        $this->entityManager->persist($quizSession);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_quiz_session_get_question', ['quizSession' => $quizSession->getId()]);
    }
}
