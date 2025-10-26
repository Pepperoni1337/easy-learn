<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

use App\Core\Quiz\Model\Quiz;
use App\Core\QuizSession\Model\GameStyle;
use App\Core\QuizSession\Service\SessionFactory\QuizSessionFactory;
use App\Core\QuizSession\Service\SessionFactory\SnowballQuizSessionFactory;
use App\Core\Shared\Traits\WithEntityManager;
use App\Core\User\Model\User;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quiz/{quiz}/start-session/{style}', name: 'app_quiz_session_start')]
final class StartSessionAction extends AbstractController
{
    use WithEntityManager;

    /**
     * @param SnowballQuizSessionFactory[] $factories
     */
    public function __construct(
        #[TaggedIterator(QuizSessionFactory::class)]
        private readonly iterable $factories,
    ) {
    }

    public function __invoke(Quiz $quiz, GameStyle $style): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new RuntimeException('User is not logged in.');
        }

        $quizSession = $this->getFactory($style)->createNewSession($quiz, $user);

        $this->entityManager->persist($quizSession);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_quiz_session_get_question', ['quizSession' => $quizSession->getId()]);
    }

    private function getFactory(GameStyle $style): QuizSessionFactory
    {
        foreach ($this->factories as $factory) {
            if ($factory->supports($style)) {
                return $factory;
            }
        }
        throw new RuntimeException('No factory found for style ' . $style->name);
    }
}
