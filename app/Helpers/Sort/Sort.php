<?php

namespace App\Helpers\Sort;

class Sort
{
    /**
     * Sorting an array by key.
     *
     * @param array $res
     * @param string $key
     * @return array
     */
    public function arrByKey(array $res, string $key): array
    {
        usort($res, function ($a, $b) use ($key) {
            if ($a[$key] == $b[$key]) {
                return 0;
            }
            return ($a[$key] > $b[$key]) ? -1 : 1;
        });

        return $res;
    }
}
