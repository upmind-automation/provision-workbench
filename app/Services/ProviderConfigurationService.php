<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ProviderConfiguration;
use Upmind\ProvisionBase\Registry\Data\ProviderRegister;

class ProviderConfigurationService
{
    public function create(
        ProviderRegister $provider,
        string $name,
        array $data
    ): ProviderConfiguration {
        $configuration = new ProviderConfiguration();
        $configuration->name = $name;
        $configuration->category_code = $provider->getCategory()->getIdentifier();
        $configuration->provider_code = $provider->getIdentifier();
        $configuration->data = $data;
        $configuration->save();

        return $configuration;
    }

    public function update(
        ProviderConfiguration $configuration,
        string $name,
        array $data
    ): ProviderConfiguration {
        $configuration->name = $name;
        $configuration->data = $data;
        $configuration->save();

        return $configuration;
    }
}
