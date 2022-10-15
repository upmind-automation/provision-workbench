<?php

declare(strict_types=1);

namespace App\Composer;

use App\Composer\Data\PackageVersions;
use App\Composer\Data\VersionData;
use Illuminate\Support\Str;

class UpmindPackages
{
    /**
     * List installed upmind provision packages.
     */
    public function listVersions(): PackageVersions
    {
        $upmindPackages = collect($this->getRawInstalledPackages())
            ->filter(function (array $packageData) {
                return Str::startsWith($packageData['name'], 'upmind/provision-provider-')
                && $packageData['name'] !== 'upmind/provision-provider-base';
            })
            ->map(function (array $packageData): VersionData {
                return new VersionData([
                    'name' => $packageData['name'],
                    'version' => $packageData['pretty_version'] ?? $packageData['version'],
                    'source' => [
                        'type' => $packageData['source']['type'] ?? $packageData['dist']['type'],
                        'url' => $packageData['source']['url'] ?? $packageData['dist']['url'],
                    ],
                ]);
            });

        return new PackageVersions([
            'packages' => $upmindPackages,
        ]);
    }

    public function getRawInstalledPackages(): array
    {
        $paths = [
            base_path('vendor/composer/installed.json'),
            base_path('composer.lock'),
        ];

        foreach ($paths as $file) {
            if (file_exists($file)) {
                if ($data = json_decode(file_get_contents($file), true)) {
                    return $data['packages'];
                }
            }
        }

        return [];
    }
}
