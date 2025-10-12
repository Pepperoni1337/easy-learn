<?php

declare(strict_types=1);

namespace App\UI\Http;

use App\Core\Quiz\Model\Quiz;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionStatus;
use App\Core\Shared\Traits\WithEntityManager;
use App\Core\User\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_dashboard')]
final class DashboardAction extends AbstractController
{
    use WithEntityManager;

    public function __invoke(): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new \RuntimeException('User is not logged in.');
        }

        return $this->render(
            'dashboard.html.twig',
            [
                'user' => UserOutput::fromUser($user),
                'availableQuizzes' => $this->getRepository(Quiz::class)->findAll(),
                'finishedQuizSessions' => $this->getRepository(QuizSession::class)->findBy([
                    QuizSession::STATUS => QuizSessionStatus::FINISHED,
                ]),
                'quizSessionsInProgress' => $this->getRepository(QuizSession::class)->findBy([
                    QuizSession::STATUS => QuizSessionStatus::IN_PROGRESS,
                ]),
            ]
        );
    }
}
