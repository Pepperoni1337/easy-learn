<?php

declare(strict_types=1);

namespace App\Util;

final class StringUtil
{
    public static function concat(string ...$parts): string
    {
        return implode('', $parts);
    }
}
