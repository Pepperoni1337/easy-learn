<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Core\Shared\Model\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class IdType extends Type
{
    public const NAME = 'id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Id
    {
        return $value === null ? null : ID::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof Id ? $value->toString() : $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
