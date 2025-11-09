<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Query;

use App\Core\Shared\Query\Query;
use App\Core\User\Model\User;

final class FindQuizSessionsInProgress implements Query
{
    public function __construct(
        public readonly User $user,
        public readonly int $limit,
    ) {
    }
}
