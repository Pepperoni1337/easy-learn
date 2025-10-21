<?php

declare(strict_types=1);

namespace App\UI\Http\Shared;

use App\Core\Quiz\Model\QuizQuestion;
use App\Core\Shared\Model\Id;

final class QuestionOutput
{
    public function __construct(
        public readonly Id $id,
        public readonly string $question,
    ) {
    }

    public static function fromQuestion(QuizQuestion $question): self
    {
        return new self(
            id: $question->getId(),
            question: $question->getQuestion(),
        );
    }
}