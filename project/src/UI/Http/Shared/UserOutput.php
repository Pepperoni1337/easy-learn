<?php

declare(strict_types=1);

namespace App\UI\Http\Shared;

use App\Core\Shared\Model\Id;
use App\Core\User\Model\User;

final class UserOutput
{
    public function __construct(
        public readonly Id $id,
        public readonly string $nickname,
    ) {
    }

    public static function fromUser(User $user): self
    {
        return new self(
            $user->getId(),
            $user->getNickname(),
        );
    }
}
