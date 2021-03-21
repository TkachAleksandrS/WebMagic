<?php

namespace App\Traits;

trait Sort {
    /**
     * Sorting an array by key.
     *
     * @param array $res
     * @param string $key
     * @return array
     */
    private function sortArrByKey(array $res, string $key): array
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
