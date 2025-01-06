<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Factories\Rules\ProviderConfigurationRuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Upmind\ProvisionBase\Registry\Registry;

class ProviderConfigurationStoreRequest extends FormRequest
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
     * @return array<string, array<array-key, string|\Illuminate\Contracts\Validation\ValidationRule>>
     *
     * @throws \InvalidArgumentException
     */
    public function rules(Registry $registry): array
    {
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
                    // We don't really expect these to be any other than strings.
                    'category_code' => (string) $this->route('category_code'),
                    'provider_code' => (string) $this->route('provider_code'),
                ]),
            ],
        ];
    }
}
