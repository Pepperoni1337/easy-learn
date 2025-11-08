<?php

declare(strict_types=1);

namespace App\Core\Shared\Traits;

use App\Core\Shared\Event\Event;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait WithEventDispatcher
{
    private MessageBusInterface $eventBus;

    #[Required]
    public function setEventBus(
        MessageBusInterface $eventBus,
    ): void {
        $this->eventBus = $eventBus;
    }

    public function dispatch(Event $event): void
    {
        $this->eventBus->dispatch($event);
    }
}
