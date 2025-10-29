<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

use App\Core\Quiz\Model\Quiz;
use App\Core\Shared\Traits\WithEntityManager;
use App\UI\Http\Shared\QuizOutput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz/{quiz}/detail', name: 'app_quiz_detail')]
final class DetailAction extends AbstractController
{
    use WithEntityManager;

    public function __invoke(Quiz $quiz): Response
    {
        return $this->render('quiz/detail.html.twig', [
            'quiz' => QuizOutput::fromQuiz($quiz),
        ]);
    }
}
