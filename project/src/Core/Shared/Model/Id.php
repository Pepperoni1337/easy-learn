<?php

declare(strict_types=1);

namespace App\Core\Shared\Model;

use Symfony\Component\Uid\Uuid;

final class Id
{
    private Uuid $uuid;

    public static function new(): self {
        return new self(Uuid::v7());
    }

    public static function fromString(string $uuid): self {
        return new self(Uuid::fromString($uuid));
    }

    public function equals(self $other): bool {
        return $this->uuid->jsonSerialize() === $other->uuid->jsonSerialize();
    }

    public function toString(): string {
        return $this->uuid->jsonSerialize();
    }

    private function __construct(
        Uuid $uuid,
    ) {
        $this->uuid = $uuid;
    }
}