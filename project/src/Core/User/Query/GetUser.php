<?php

declare(strict_types=1);

namespace App\Core\User\Query;

use App\Core\Shared\Query\Query;

final class GetUser implements Query
{
    public function __construct(
        public readonly string $test,
    ) {
    }
}
