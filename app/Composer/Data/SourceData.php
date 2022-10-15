<?php

declare(strict_types=1);

namespace App\Composer\Data;

use Upmind\ProvisionBase\Provider\DataSet\DataSet;
use Upmind\ProvisionBase\Provider\DataSet\Rules;

/**
 * @property-read string $type Repository type
 * @property-read string $url Source URL or path
 */
class SourceData extends DataSet
{
    public static function rules(): Rules
    {
        return new Rules([
            'type' => ['required', 'string'],
            'url' => ['required', 'string'],
        ]);
    }
}
