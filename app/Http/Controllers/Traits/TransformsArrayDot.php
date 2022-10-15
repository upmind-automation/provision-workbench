<?php

declare(strict_types=1);

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Arr;

trait TransformsArrayDot
{
    public function undot($array, bool $keepNulls = false)
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
