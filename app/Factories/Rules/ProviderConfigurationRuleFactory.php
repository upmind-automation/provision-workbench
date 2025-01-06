<?php

declare(strict_types=1);

namespace App\Factories\Rules;

use App\Rules\ProviderConfigurationRule;
use InvalidArgumentException;
use Upmind\ProvisionBase\Registry\Registry;

class ProviderConfigurationRuleFactory
{
    /**
     * @throws \InvalidArgumentException
     */
    public static function create(array $params): ProviderConfigurationRule
    {
        self::validate($params);

        return new ProviderConfigurationRule($params['registry'], $params['category_code'], $params['provider_code']);
    }

    /**
     * @throws \InvalidArgumentException
     */
    private static function validate(array $params): void
    {
        $required = ['registry', 'category_code', 'provider_code'];

        foreach ($required as $key) {
            if (!isset($key, $params)) {
                throw new InvalidArgumentException('Missing required parameter: ' . $key);
            }
        }

        if (!is_string($params['category_code'])) {
            throw new InvalidArgumentException('Expected string for `category_code`');
        }

        if (!is_string($params['provider_code'])) {
            throw new InvalidArgumentException('Expected string for `provider_code`');
        }

        if (!($params['registry'] instanceof Registry)) {
            throw new InvalidArgumentException('Expected \Upmind\ProvisionBase\Registry instance for `registry`');
        }
    }
}
