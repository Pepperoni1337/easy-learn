<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

use App\Core\Quiz\Service\QuizGenerator;
use App\Core\Shared\Traits\WithEntityManager;
use App\Core\User\Model\User;
use App\UI\Http\Shared\UserOutput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz/create', name: 'app_quiz_create')]
final class CreateQuizAction extends AbstractController
{
    use WithEntityManager;

    public function __construct(
        private readonly QuizGenerator $quizGenerator,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new \RuntimeException('User is not logged in.');
        }

        $form = $this->createForm(QuizType::class, new QuizDto());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var QuizDto $quizDto */
            $quizDto = $form->getData();

            $quiz = $this->quizGenerator->generateQuiz($user, $quizDto);

            $this->entityManager->persist($quiz);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_quiz_detail', ['quiz' => $quiz->getId()]);
        }

        return $this->render('quiz/create.html.twig', [
            'user' => UserOutput::fromUser($user),
            'form' => $form->createView(),
        ]);
    }
}
