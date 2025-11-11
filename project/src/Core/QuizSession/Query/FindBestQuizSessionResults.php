<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Query;

use App\Core\Quiz\Model\Quiz;
use App\Core\Shared\Query\Query;

final class FindBestQuizSessionResults implements Query
{
    public function __construct(
        public readonly Quiz $quiz,
        public readonly int $limit,
    ) {
    }
}