<?php

declare(strict_types=1);

namespace App\UI\Http;

use App\Core\Quiz\Model\Quiz;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionStatus;
use App\Core\Shared\Traits\WithEntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_index')]
final class DashboardAction extends AbstractController
{
    use WithEntityManager;

    public function __invoke(): Response
    {
        return $this->render(
            'dashboard.html.twig',
            [
                'quizzes' => $this->getRepository(Quiz::class)->findAll(),
                'finishedSessions' => $this->getRepository(QuizSession::class)->findBy([
                    QuizSession::STATUS => QuizSessionStatus::FINISHED,
                ]),
                'sessionsInProgress' => $this->getRepository(QuizSession::class)->findBy([
                    QuizSession::STATUS => QuizSessionStatus::IN_PROGRESS,
                ]),
            ]
        );
    }
}
