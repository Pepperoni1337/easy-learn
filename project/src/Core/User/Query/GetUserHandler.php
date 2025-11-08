<?php

declare(strict_types=1);

namespace App\Core\User\Query;

use App\Core\Shared\Query\QueryHandler;

final class GetUserHandler implements QueryHandler
{
    public function __invoke(GetUser $query): string
    {
        return $query->test;
    }
}
