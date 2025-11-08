<?php

declare(strict_types=1);

namespace App\Core\Shared\Traits;

use App\Core\Shared\Query\Query;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait WithQueryBus
{
    private MessageBusInterface $queryBus;

    #[Required]
    public function setQueryBus(
        MessageBusInterface $queryBus,
    ): void {
        $this->queryBus = $queryBus;
    }

    public function query(Query $query): mixed
    {
        return $this->queryBus->dispatch($query);
    }
}
