<?php

declare(strict_types=1);

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use RuntimeException;
use Upmind\ProvisionBase\Registry\Data\CategoryRegister;
use Upmind\ProvisionBase\Registry\Data\FunctionRegister;
use Upmind\ProvisionBase\Registry\Data\ProviderRegister;
use Upmind\ProvisionBase\Registry\Registry;

trait InteractsWithRegistry
{
    public function getCategory(Registry $registry, Request $request, bool $orFail = true): ?CategoryRegister
    {
        $categoryCode = $request->route('category_code', $request->get('category_code'));

        if ($category = $registry->getCategory($categoryCode)) {
            return $category;
        }

        if (!$orFail) {
            return null;
        }

        throw new RuntimeException(
            sprintf('Provision category "%s" not installed', $categoryCode)
        );
    }

    public function getProvider(Registry $registry, Request $request, bool $orFail = true): ?ProviderRegister
    {
        if (!$category = $this->getCategory($registry, $request, $orFail)) {
            return null;
        }

        $providerCode = $request->route('provider_code', $request->get('provider_code'));

        if ($provider = $category->getProvider($providerCode)) {
            return $provider;
        }

        if (!$orFail) {
            return null;
        }

        throw new RuntimeException(
            sprintf('Provision %s provider "%s" not installed', $category->getIdentifier(), $providerCode)
        );
    }

    public function getFunction(Registry $registry, Request $request, bool $orFail = true): ?FunctionRegister
    {
        if (!$category = $this->getCategory($registry, $request, $orFail)) {
            return null;
        }

        $functionName = $request->route('function_name', $request->get('function_name'));

        if ($function = $category->getFunction($functionName)) {
            return $function;
        }

        if (!$orFail) {
            return null;
        }

        throw new RuntimeException(
            sprintf('Provision %s function "%s()" not found', $category->getIdentifier(), $functionName)
        );
    }

    public function listCategoryCodes(Registry $registry): array
    {
        return $registry->getCategories()
            ->map(function (CategoryRegister $category) {
                return $category->getIdentifier();
            })
            ->all();
    }

    public function listProviderCodes(Registry $registry): array
    {
        return $registry->getCategories()
            ->reduce(function (Collection $providerCodes, CategoryRegister $category) {
                return $category->getProviders()
                    ->map(function (ProviderRegister $provider) {
                        return $provider->getIdentifier();
                    })
                    ->merge($providerCodes);
            }, collect())
            ->all();
    }
}
