<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Validation\Validator;
use Upmind\ProvisionBase\Registry\Registry;

class ProviderConfigurationRule implements ValidationRule, ValidatorAwareRule
{
    /**
     * The validator instance.
     *
     * @var \Illuminate\Validation\Validator
     */
    protected Validator $validator;
    private Registry $registry;
    private string $categoryCode;
    private string $providerCode;

    public function __construct(Registry $registry, string $categoryCode, string $providerCode)
    {
        $this->registry = $registry;
        $this->categoryCode = $categoryCode;
        $this->providerCode = $providerCode;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $provider = $this->registry->getProvider($this->categoryCode, $this->providerCode);

        if ($provider === null) {
            $fail(sprintf(
                'The provision %s provider %s is not installed.',
                $this->categoryCode,
                $this->providerCode
            ));
        }

        $rules = $provider->getConstructor()->getParameter()->getRules()->expand();

        $this->validator->setRules($rules);
        $this->validator->setData($value);

        $this->validator->validate();
    }

    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;

        return $this;
    }
}
