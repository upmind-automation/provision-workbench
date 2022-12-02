<?php

declare(strict_types=1);

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Arr;

trait TransformsArrayDot
{
    /**
     * Transform the given dot-notated array to multi-associative; effectively
     * reverses Arr::dot().
     *
     * @param mixed[] $array
     * @param bool $keepNulls Whether or not to keep null values
     *
     * @return mixed[]
     */
    public function undot($array, bool $keepNulls = false): array
    {
        $results = [];

        foreach ($array as $key => $value) {
            if ($keepNulls || $value !== null) {
                Arr::set($results, $key, $value);
            }
        }

        return $results;
    }
}
