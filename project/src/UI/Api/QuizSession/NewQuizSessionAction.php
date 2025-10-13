<?php

declare(strict_types=1);

namespace App\UI\Api\QuizSession;

use App\UI\Http\Shared\QuizSessionOutput;

final class NewQuizSessionAction
{
    public function __invoke(NewQuizSessionInput $input): QuizSessionOutput
    {

        return new QuizSessionOutput();
    }
}
