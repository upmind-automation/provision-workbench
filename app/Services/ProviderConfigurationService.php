<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ProviderConfiguration;
use App\Models\ProvisionRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Upmind\ProvisionBase\Registry\Data\ProviderRegister;

class ProviderConfigurationService
{
    /**
     * @throws ValidationException If the given configuration data is invalid
     */
    public function create(
        ProviderRegister $provider,
        string $name,
        array $data
    ): ProviderConfiguration {
        $this->validateData($provider, $data);

        $configuration = new ProviderConfiguration();
        $configuration->name = $name;
        $configuration->category_code = $provider->getCategory()->getIdentifier();
        $configuration->provider_code = $provider->getIdentifier();
        $configuration->data = $data;
        $configuration->save();

        return $configuration;
    }

    /**
     * @throws ValidationException If the given configuration data is invalid
     */
    public function update(
        ProviderConfiguration $configuration,
        string $name,
        array $data
    ): ProviderConfiguration {
        $this->validateData($configuration->getProvider(), $data);

        $configuration->name = $name;
        $configuration->data = $data;
        $configuration->save();

        return $configuration;
    }

    public function delete(ProviderConfiguration $configuration)
    {
        $requestService = new ProvisionRequestService();
        ProvisionRequest::where('configuration_id', $configuration->id)
            ->chunk(20, function ($requests) use ($requestService) {
                foreach ($requests as $request) {
                    $requestService->delete($request);
                }
            });

        $configuration->delete();
    }

    /**
     * @throws ValidationException If the given configuration data is invalid
     */
    protected function validateData(ProviderRegister $provider, array $data): void
    {
        $rules = $provider->getConstructor()->getParameter()->getRules()->expand();

        Validator::make($data, $rules)->validate();
    }
}
