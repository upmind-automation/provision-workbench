<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Models\ProviderConfiguration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Upmind\ProvisionBase\Registry\Registry;

class ProvisionRequestNewController extends Controller
{
    use InteractsWithRegistry;

    public function __invoke(Request $request, Registry $registry)
    {
        if ($request->has('configuration_id')) {
            if ($configuration = ProviderConfiguration::find($request->get('configuration_id'))) {
                $category = $configuration->getCategory();
                $provider = $configuration->getProvider();

                $function = $category->getFunction($request->get('function_name'));
            }
        }

        $category = $category ?? $this->getCategory($registry, $request, false);
        $provider = $provider ?? $this->getProvider($registry, $request, false);
        $function = $function ?? $this->getFunction($registry, $request, false);

        $configurations = isset($configuration)
            ? new Collection([$configuration])
            : ProviderConfiguration::query()
                ->when($category, function (Builder $query) use ($category) {
                    return $query->where('category_code', $category->getIdentifier());
                })
                ->when($provider, function (Builder $query) use ($provider) {
                    return $query->where('provider_code', $provider->getIdentifier());
                })
                ->get();

        return view('provision-request-new', [
            'request' => $request,
            'registry' => $registry,
            'configurations' => $configurations,
            'configuration' => $configuration ?? null,
            'category' => $category,
            'provider' => $provider,
            'function' => $function,
        ]);
    }
}
