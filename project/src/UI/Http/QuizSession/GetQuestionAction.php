<?php

declare(strict_types=1);

namespace App\UI\Http\QuizSession;

use App\Core\QuizSession\Model\QuizSession;
use App\UI\Http\Shared\QuestionOutput;
use App\UI\Http\Shared\QuizSessionLevelOutput;
use App\UI\Http\Shared\QuizSessionOutput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz-session/{quizSession}/get-question', name: 'app_quiz_session_get_question', methods: ['GET'])]
final class GetQuestionAction extends AbstractController
{
    public function __invoke(QuizSession $quizSession)
    {
        return $this->render(
            'quiz-session/get-question.html.twig',
            [
                'question' => QuestionOutput::fromQuestion($quizSession->getCurrentQuestion()),
                'level' => QuizSessionLevelOutput::fromQuizSessionLevel($quizSession->getCurrentLevel()),
                'quizSession' => QuizSessionOutput::fromQuizSession($quizSession),
            ],
        );
    }
}
