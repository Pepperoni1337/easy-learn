<?php

declare(strict_types=1);

namespace App\Core\Quiz\Query;

use App\Core\Shared\Query\Query;
use App\Core\User\Model\User;

final class FindMyQuizzes implements Query
{
    public function __construct(
        public readonly User $user,
        public readonly int $limit,
    ) {
    }
}