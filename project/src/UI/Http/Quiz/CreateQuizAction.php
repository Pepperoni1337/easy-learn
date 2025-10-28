<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

use App\Application\AI\QuestionGenerator;
use App\Core\Quiz\Model\Quiz;
use App\Core\Quiz\Model\QuizQuestion;
use App\Core\Shared\Traits\WithEntityManager;
use App\Core\User\Model\User;
use App\Infrastructure\OpenAI\PromptService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz/create', name: 'app_quiz_create')]
final class CreateQuizAction extends AbstractController
{
    use WithEntityManager;

    private const MIN_COUNT = 5;
    private const MAX_COUNT = 8;

    public function __construct(
        private readonly QuestionGenerator $generator,
        private readonly PromptService $promptService,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(QuizType::class, new QuizDto());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var QuizDto $quizDto */
            $quizDto = $form->getData();

            $user = $this->getUser();

            if (!$user instanceof User) {
                throw new \RuntimeException('User is not logged in.');
            }

            $quiz = new Quiz(
                $user,
            );
            $quiz->setTitle($quizDto->name);
            $quiz->setDescription($quizDto->prompt);

            $questions = $this->generator->generateQuestions(
                $this->promptService->createPrompt($quizDto->prompt),
                self::MIN_COUNT,
                self::MAX_COUNT
            );

            foreach ($questions as $questionDto) {
                $quizQuestion = new QuizQuestion(
                    quiz: $quiz,
                    question: $questionDto->question,
                    answer: $questionDto->answer,
                );
                $quizQuestion->setWrongAnswer1($questionDto->wrongAnswer1);
                $quizQuestion->setWrongAnswer2($questionDto->wrongAnswer2);
                $quizQuestion->setWrongAnswer3($questionDto->wrongAnswer3);
                $quiz->addQuestion($quizQuestion);
            }

            $this->entityManager->persist($quiz);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_quiz_detail', ['quiz' => $quiz->getId()]);
        }

        return $this->render('quiz/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
