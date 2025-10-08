<?php

declare(strict_types=1);

namespace App\Util;

use Symfony\Component\Uid\Uuid;

final class RandomUtil
{
    public static function generateShareToken(string $uuid, int $length = 16): string {
        $hash = hash('sha256', $uuid, true);
        $base64 = rtrim(strtr(base64_encode($hash), '+/', '-_'), '=');

        return substr($base64, 0, $length);
    }
}