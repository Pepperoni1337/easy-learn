<?php

declare(strict_types=1);

namespace App\Core\User\Event;

use App\Core\Shared\Model\Event;

final class UserCreated implements Event
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
