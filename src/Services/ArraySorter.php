<?php

namespace Src\Services;

use Src\Enums\SortDirection;


/**
 * A utility class for sorting arrays by a specific key
 * with optional sorting direction
 */
class ArraySorter
{
    /**
     * Sorts an array of associative arrays
     * by a specified key
     * @param string $key
     * @param array $data
     * @param int $direction
     * @return array
     */
    public static function sortByKey(string $key, array $data, int $direction = SortDirection::ASC): array
    {
        usort($data, fn($a, $b) => self::sort($a, $b, $key, $direction));
        return $data;
    }

    /**
     * Comparison function for sorting two array elements
     * by a specified key
     * @param array $a
     * @param array $b
     * @param string $key
     * @param int $direction
     * @return int
     */
    private static function sort(array $a, array $b, string $key, int $direction): int
    {
        if ($a[$key] == $b[$key])
            return 0;

        return ($a[$key] < $b[$key]) ? -$direction : $direction;
    }
}
