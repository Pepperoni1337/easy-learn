<?php

declare(strict_types=1);

namespace App\Core\User\Event;

use App\Core\Shared\Event\SyncEventHandler;

final class TestHandler implements SyncEventHandler
{
    public function __invoke(UserCreated $event): void
    {
        dd($event);
    }
}
