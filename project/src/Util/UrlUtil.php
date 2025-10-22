<?php

declare(strict_types=1);

namespace App\Util;

final class UrlUtil
{
    public static function createUrl(
        bool $isHttps,
        string $host,
        ?int $port = null,
        string $path = '/',
        array $query = [],
        ?string $fragment = null,
    ): string {
        return StringUtil::concat(
            $isHttps ? 'https' : 'http',
            '://',
            $host,
            $port !== null ? ':' . $port : '',
            '/',
            $path,
            !empty($query) ? '?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986) : '',
            $fragment !== null ? '#' . $fragment : '',
        );
    }
}