<?php

declare(strict_types=1);

namespace App\Core\Quiz\Model;

final class AnswerResult
{
    public function __construct(
        public readonly bool $isCorrect,
        public readonly string $correctAnswer,
        public readonly bool $isFinished,
        public readonly ?QuizQuestion $nextQuestion
    ) {

    }
}