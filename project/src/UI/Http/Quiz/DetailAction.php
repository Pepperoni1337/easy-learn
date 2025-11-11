<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

use App\Core\Quiz\Model\Quiz;
use App\Core\QuizSession\Model\QuizSessionResult;
use App\Core\QuizSession\Query\FindBestQuizSessionResults;
use App\Core\Shared\Traits\WithQueryBus;
use App\Core\User\Model\User;
use App\UI\Http\Shared\QuizOutput;
use App\UI\Http\Shared\QuizSessionResultOutput;
use App\UI\Http\Shared\UserOutput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz/{quiz}/detail', name: 'app_quiz_detail')]
final class DetailAction extends AbstractController
{
    use WithQueryBus;

    public function __invoke(Quiz $quiz): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new \RuntimeException('User is not logged in.');
        }

        $bestResults = array_map(
            static fn (QuizSessionResult $result) => QuizSessionResultOutput::fromQuizSessionResult($result),
            $this->query(new FindBestQuizSessionResults($quiz, 10)),
        );

        return $this->render('quiz/detail.html.twig', [
            'user' => UserOutput::fromUser($user),
            'quiz' => QuizOutput::fromQuiz($quiz),
            'bestResults' => $bestResults,
        ]);
    }
}
