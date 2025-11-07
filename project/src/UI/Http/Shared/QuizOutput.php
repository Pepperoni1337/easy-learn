<?php

declare(strict_types=1);

namespace App\UI\Http\Shared;

use App\Core\Quiz\Model\Quiz;
use App\Core\Shared\Model\Id;
use App\Core\User\Model\User;

final class QuizOutput
{
    public function __construct(
        public readonly Id $id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $shareToken,
        public readonly int $numberOfQuestions,
        public readonly ?User $createdBy,
        public readonly ?float $avgRating,
    ) {
    }

    public static function fromQuiz(Quiz $quiz): self
    {
        return new self(
            $quiz->getId(),
            $quiz->getTitle(),
            $quiz->getDescription(),
            $quiz->getShareToken(),
            $quiz->getQuestions()->count(),
            $quiz->getCreatedBy(),
            $quiz->getAvgRating(),
        );
    }
}
