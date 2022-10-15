<?php

declare(strict_types=1);

namespace App\Composer\Data;

use Upmind\ProvisionBase\Provider\DataSet\DataSet;
use Upmind\ProvisionBase\Provider\DataSet\Rules;

/**
 * @property-read VersionData[] $packages
 */
class PackageVersions extends DataSet
{
    public static function rules(): Rules
    {
        return new Rules([
            'packages' => ['present', 'array'],
            'packages.*' => [VersionData::class],
        ]);
    }
}
