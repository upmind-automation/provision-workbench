<?php

declare(strict_types=1);

namespace App\Composer\Data;

use Upmind\ProvisionBase\Provider\DataSet\DataSet;
use Upmind\ProvisionBase\Provider\DataSet\Rules;

/**
 * @property-read string $name
 * @property-read string $version
 */
class VersionData extends DataSet
{
    public static function rules(): Rules
    {
        return new Rules([
            'name' => ['required', 'string'],
            'version' => ['required', 'string'],
            'source' => ['required', SourceData::class],
        ]);
    }
}
