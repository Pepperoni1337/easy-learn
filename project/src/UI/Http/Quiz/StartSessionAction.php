<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

use App\Core\Quiz\Model\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz/{quiz}/start-session', name: 'app_quiz_session_start')]
final class StartSessionAction extends AbstractController
{
    public function __invoke(Quiz $quiz): Response
    {
        dd($quiz);
        return new RedirectResponse();
    }
}