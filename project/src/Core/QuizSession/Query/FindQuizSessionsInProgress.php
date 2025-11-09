<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Query;

use App\Core\Shared\Query\Query;

final class FindQuizSessionsInProgress implements Query
{
    public function __construct(
        public readonly int $limit,
    ) {
    }
}
