<?php

declare(strict_types=1);

namespace App\Core\User\Event;

final class UserCreated
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}