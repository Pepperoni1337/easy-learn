<?php

declare(strict_types=1);

namespace App\Core\Shared\Traits;

use App\Core\Shared\Query\Query;
use App\Core\Shared\Query\QueryBus;
use Symfony\Contracts\Service\Attribute\Required;

trait WithQueryBus
{
    private QueryBus $queryBus;

    #[Required]
    public function setQueryBus(
        QueryBus $queryBus,
    ): void {
        $this->queryBus = $queryBus;
    }

    public function query(Query $query): mixed
    {
        return $this->queryBus->ask($query);
    }
}
