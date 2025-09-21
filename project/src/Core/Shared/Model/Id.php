<?php

declare(strict_types=1);

namespace App\Core\Shared\Model;

use Symfony\Component\Uid\Uuid;

final class Id
{
    private Uuid $uuid;

    public static function new(): self {
        return new self();
    }

    public function equals(self $id): bool {
        return $this->uuid === $id->uuid;
    }

    private function __construct(
    ) {
        $this->uuid = Uuid::v7();
    }
}