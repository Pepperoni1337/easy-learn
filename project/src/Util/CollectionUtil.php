<?php

declare(strict_types=1);

namespace App\Util;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class CollectionUtil
{
    public static function sliceFromStart(Collection $collection, int $n): Collection
    {
        $result = new ArrayCollection();

        $i = 1;
        foreach ($collection as $element) {
            $result->add($element);
            if ($i >= $n) {
                return $result;
            }
            $i++;
        }

        return $result;
    }
}
