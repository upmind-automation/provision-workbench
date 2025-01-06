<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Factories\Rules\ProviderConfigurationRuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Upmind\ProvisionBase\Registry\Registry;

class ProviderConfigurationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<array-key, string|\App\Rules\ProviderConfigurationRule>>
     *
     * @throws \InvalidArgumentException
     */
    public function rules(Registry $registry): array
    {
        /** @var \App\Models\ProviderConfiguration $configuration */
        $configuration = $this->route('configuration');

        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'field_values' => [
                'array',
                'nullable',
                ProviderConfigurationRuleFactory::create([
                    'registry' => $registry,
                    // Pass category_code and provider_code from the configuration model
                    'category_code' => $configuration->category_code,
                    'provider_code' => $configuration->provider_code,
                ]),
            ],
        ];
    }
}
