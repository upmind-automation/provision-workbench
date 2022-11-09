<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Models\ProviderConfiguration;
use App\Models\ProvisionRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Upmind\ProvisionBase\Registry\Registry;

class ProvisionRequestNewController extends Controller
{
    use InteractsWithRegistry;

    public function __invoke(Request $request, Registry $registry)
    {
        if ($request->has('provision_request_id')) {
            if ($provision_request = ProvisionRequest::find($request->get('provision_request_id'))) {
                $category = $provision_request->getCategory();
                $provider = $provision_request->getProvider();
                $configuration = $provision_request->configuration;
                $function = $provision_request->getFunction();

                if ($request->has('function_name')) {
                    $function = $category->getFunction($request->get('function_name'));
                }

                $parameter_data = $provision_request->parameter_data;

                if ($request->get('use_result_data')) {
                    $parameter_data = array_replace_recursive(
                        $parameter_data,
                        $provision_request->getResult()->getData() ?? []
                    );
                }
            }
        }

        if ($request->has('configuration_id')) {
            if ($configuration = ProviderConfiguration::find($request->get('configuration_id'))) {
                $category = $configuration->getCategory();
                $provider = $configuration->getProvider();

                $function = $function ?? $category->getFunction($request->get('function_name'));
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
            'provision_request' => $provision_request ?? null,
            'parameter_data' => $parameter_data ?? [],
        ]);
    }
}
