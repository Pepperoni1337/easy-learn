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

    public static function sliceFromCollection(Collection $collection, int $start, int $end): Collection
    {
        $result = new ArrayCollection();

        $i = 0;
        foreach ($collection as $element) {
            if ($i >= $start && $i <= $end) {
                $result->add($element);
            }
            $i++;
        }

        return $result;
    }

    /**
     * @template T
     * @param Collection<int, T> $collection
     * @return T|null
     */
    public static function getRandomElement(Collection $collection): mixed
    {
        if ($collection->isEmpty()) {
            return null;
        }

        $array = $collection->toArray();
        $randomKey = array_rand($array);

        return $array[$randomKey];
    }
}
