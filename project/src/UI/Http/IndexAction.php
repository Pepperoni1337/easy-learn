<?php

declare(strict_types=1);

namespace App\UI\Http;

use App\Core\Quiz\Model\Quiz;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\Shared\Traits\WithEntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class IndexAction extends AbstractController
{
use WithEntityManager;

    public function __invoke(): Response
    {
        return $this->render(
            'index.html.twig',
            [
                'quizzes' => $this->getRepository(Quiz::class)->findAll(),
                'quizSessions' => $this->getRepository(QuizSession::class)->findAll(),
            ]
        );
    }
}