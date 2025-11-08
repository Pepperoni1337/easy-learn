<?php

declare(strict_types=1);

namespace App\Core\Quiz\Query;

use App\Core\Shared\Query\Query;

final class FindMostPlayedQuizzes implements Query
{
    public function __construct(
        public readonly int $limit,
    ) {
    }
}