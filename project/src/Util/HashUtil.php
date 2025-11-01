<?php

declare(strict_types=1);

namespace App\Util;

final class HashUtil
{
    public static function createHash(int $length): string
    {
        return bin2hex(random_bytes($length));
    }
}
