<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

use App\Core\Quiz\Model\Quiz;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionStatus;
use App\Core\Shared\Traits\WithEntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz/{quiz}/detail', name: 'app_quiz_detail')]
final class DetailAction extends AbstractController
{
    use WithEntityManager;

    public function __invoke(Quiz $quiz): Response
    {
        $sessionRepository = $this->getRepository(QuizSession::class);

        return $this->render('quiz/detail.html.twig', [
            'quiz' => $quiz,
            'sessionsInProgress' => $sessionRepository->findBy([
                QuizSession::QUIZ => $quiz,
                QuizSession::STATUS => QuizSessionStatus::IN_PROGRESS,
            ]),
            'finishedSessions' => $sessionRepository->findBy([
                QuizSession::QUIZ => $quiz,
                QuizSession::STATUS => QuizSessionStatus::FINISHED,
            ]),
        ]);
    }
}