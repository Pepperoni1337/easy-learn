<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

use App\Core\Quiz\Model\Quiz;
use App\Core\Quiz\Model\QuizRating;
use App\Core\Shared\Traits\WithEntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/quiz/{quiz}/rate', name: 'app_quiz_rate', methods: ['POST'])]
final class RateQuizAction extends AbstractController
{
    use WithEntityManager;

    public function __invoke(Quiz $quiz, Request $request): Response {

        $rating = $request->request->get('rating');

        if ($rating !== null) {
            $userRating = new QuizRating(
                quiz: $quiz,
                user: $this->getUser(),
                rating: (int)$rating
            );

            $this->entityManager->persist($userRating);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_quiz_detail', [
            'quiz' => $quiz->getId(),
        ]);
    }
}