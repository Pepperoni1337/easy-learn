<?php

declare(strict_types=1);

namespace App\Core\User\Event;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'sync')]
final class TestHandler
{
    public function __invoke(UserCreated $event): void
    {
        dd($event);
    }
}
