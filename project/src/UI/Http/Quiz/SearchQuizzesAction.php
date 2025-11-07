<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

use App\Core\Quiz\Model\Quiz;
use App\Core\Shared\Traits\WithEntityManager;
use App\UI\Http\Shared\QuizOutput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz/search', name: 'app_quiz_search', methods: ['GET'])]
final class SearchQuizzesAction extends AbstractController
{
    use WithEntityManager;

    public function __invoke(Request $request)
    {
        $search = $request->query->get('search');

        if ($search === null) {
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('quiz/search.html.twig', [
            'result' => array_map(static fn(Quiz $quiz) => QuizOutput::fromQuiz($quiz), $this->findResults($search))
        ]);
    }

    private function findResults(string $search): array
    {
        //refactor to query
        return $this->getRepository(Quiz::class)->findBy(['name' => $search]);
    }
}