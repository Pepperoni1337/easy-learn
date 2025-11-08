<?php

declare(strict_types=1);

namespace App\Core\Shared\Query;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class QueryBus
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    public function ask(object $query): mixed
    {
        $envelope = $this->bus->dispatch($query);
        return $envelope->last(HandledStamp::class)?->getResult();
    }
}
