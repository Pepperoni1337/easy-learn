<?php

declare(strict_types=1);

namespace App\UI\Http\Shared;

use App\Core\QuizSession\Model\QuizSessionResult;

final class QuizSessionResultOutput
{

    public function __construct(
        public readonly int $score,
    ) {
    }

    public static function fromQuizSessionResult(QuizSessionResult $result): self
    {
        return new self(
            $result->getScore(),
        );
    }
}