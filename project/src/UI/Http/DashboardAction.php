<?php

declare(strict_types=1);

namespace App\UI\Http;

use App\Core\Quiz\Model\Quiz;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionStatus;
use App\Core\Shared\Traits\WithEntityManager;
use App\Core\User\Model\User;
use App\UI\Http\Shared\QuizOutput;
use App\UI\Http\Shared\QuizSessionOutput;
use App\UI\Http\Shared\UserOutput;
use RuntimeException;
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
            throw new RuntimeException('User is not logged in.');
        }

        $availableQuizzesOutput = array_map(
            static fn (Quiz $quiz) => QuizOutput::fromQuiz($quiz),
            $this->getRepository(Quiz::class)->findAll()
        );

        $finishedQuizSessionsOutput = array_map(
            static fn (QuizSession $quizSession) => QuizSessionOutput::fromQuizSession($quizSession),
            $this->getRepository(QuizSession::class)->findBy([
                QuizSession::STATUS => QuizSessionStatus::FINISHED,
            ])
        );

        $quizSessionsInProgressOutput = array_map(
            static fn (QuizSession $quizSession) => QuizSessionOutput::fromQuizSession($quizSession),
            $this->getRepository(QuizSession::class)->findBy([
                QuizSession::STATUS => QuizSessionStatus::IN_PROGRESS,
            ])
        );

        return $this->render(
            'dashboard.html.twig',
            [
                'user' => UserOutput::fromUser($user),
                'availableQuizzes' => $availableQuizzesOutput,
                'finishedQuizSessions' => $finishedQuizSessionsOutput,
                'quizSessionsInProgress' => $quizSessionsInProgressOutput,
            ]
        );
    }
}
