<?php

declare(strict_types=1);

namespace App\UI\Http;

use App\Core\Quiz\Model\Quiz;
use App\Core\Quiz\Query\FindAvailableQuizzes;
use App\Core\Quiz\Query\FindMyQuizzes;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Query\FindFinishedQuizSessions;
use App\Core\QuizSession\Query\FindQuizSessionsInProgress;
use App\Core\Shared\Traits\WithEntityManager;
use App\Core\Shared\Traits\WithQueryBus;
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
    use WithQueryBus;

    public function __invoke(): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new RuntimeException('User is not logged in.');
        }

        $userOutput = UserOutput::fromUser($user);

        $myQuizzesOutput = array_map(
            static fn (Quiz $quiz) => QuizOutput::fromQuiz($quiz),
            $this->query(new FindMyQuizzes($user, 100)),
        );

        $availableQuizzesOutput = array_map(
            static fn (Quiz $quiz) => QuizOutput::fromQuiz($quiz),
            $this->query(new FindAvailableQuizzes(100)),
        );

        $finishedQuizSessionsOutput = array_map(
            static fn (QuizSession $quizSession) => QuizSessionOutput::fromQuizSession($quizSession),
            $this->query(new FindFinishedQuizSessions(100)),
        );

        $quizSessionsInProgressOutput = array_map(
            static fn (QuizSession $quizSession) => QuizSessionOutput::fromQuizSession($quizSession),
            $this->query(new FindQuizSessionsInProgress(100)),
        );

        return $this->render(
            'dashboard.html.twig',
            [
                'user' => $userOutput,
                'myQuizzes' => $myQuizzesOutput,
                'availableQuizzes' => $availableQuizzesOutput,
                'finishedQuizSessions' => $finishedQuizSessionsOutput,
                'quizSessionsInProgress' => $quizSessionsInProgressOutput,
            ]
        );
    }
}
