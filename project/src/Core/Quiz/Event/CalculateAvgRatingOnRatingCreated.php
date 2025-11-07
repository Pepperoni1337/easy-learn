<?php

declare(strict_types=1);

namespace App\Core\Quiz\Event;

use App\Core\Quiz\Model\QuizRating;
use App\Core\Shared\Traits\WithEntityManager;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'sync')]
final class CalculateAvgRatingOnRatingCreated
{
    use WithEntityManager;

    public function __invoke(RatingCreated $event): void
    {
        $rating = $event->rating;

        $quiz = $rating->getQuiz();

        $repo = $this->entityManager->getRepository(QuizRating::class);

        $quizRatings = $repo->findBy([QuizRating::QUIZ => $quiz]);

        $avg = array_reduce($quizRatings, static fn (int $sum, QuizRating $rating) => $sum + $rating->getRating(), 0) / count($quizRatings);

        $quiz->setAvgRating($avg);

        $this->entityManager->persist($quiz);
        $this->entityManager->flush();
    }
}