<?php

declare(strict_types=1);

namespace App\Util;

final class ArrayUtil
{
    public static function shuffle(array $possibleAnswers): array
    {
        $pool = array_values($possibleAnswers);

        $result = [];
        $n = count($pool);

        for ($i = $n; $i > 0; $i--) {
            $j = random_int(0, $i - 1);

            $result[] = $pool[$j];

            $pool[$j] = $pool[$i - 1];
            array_pop($pool);
        }

        return $result;
    }
}
