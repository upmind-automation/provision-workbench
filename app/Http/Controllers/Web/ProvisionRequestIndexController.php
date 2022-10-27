<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Models\ProviderConfiguration;
use App\Models\ProvisionRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Upmind\ProvisionBase\Registry\Data\CategoryRegister;
use Upmind\ProvisionBase\Registry\Data\ProviderRegister;
use Upmind\ProvisionBase\Registry\Registry;

class ProvisionRequestIndexController extends Controller
{
    use InteractsWithRegistry;

    public function __invoke(Request $request, Registry $registry, ProvisionRequest $provision_request)
    {
        $columns = [
            'id',
            'category_code',
            'provider_code',
            'configuration_id',
            'function_name',
            'result_status',
            'result_message',
            'execution_time',
            'created_at',
            'updated_at',
        ];

        $filters = collect($request->all([
            'category_code',
            'provider_code',
            'configuration_id',
            'function_name',
            'result_status',
        ]))->filter()->map(function ($filter) {
            if ($filter === 'null') {
                return null;
            }

            return $filter;
        })->all();

        $order = in_array($request->get('order'), $columns)
            ? $request->get('order')
            : 'updated_at';
        $direction = in_array($request->get('direction'), ['asc', 'desc'])
            ? $request->get('direction')
            : 'desc';

        $category = $this->getCategory($registry, $request, false);
        $provider = $this->getProvider($registry, $request, false);
        $function = $this->getFunction($registry, $request, false);
        /** @var ProviderConfiguration|null $configuration */
        $configuration = $request->get('configuration_id')
            ? ProviderConfiguration::find($request->get('configuration_id'))
            : null;

        if ($configuration) {
            $category = $configuration->getCategory();
            $provider = $configuration->getProvider();
        }

        $query = ProvisionRequest::with('configuration')
            ->whereIn('category_code', $this->listCategoryCodes($registry))
            ->whereIn('provider_code', $this->listProviderCodes($registry))
            ->when($filters, function (Builder $query) use ($filters) {
                return $query->where($filters);
            })
            ->when($order, function (Builder $query) use ($order, $direction) {
                return $query->orderBy($order, $direction);
            });

        $provision_requests = $query->paginate(
            $request->get('limit') ?: 10,
            $columns
        );

        if ($provision_requests->isEmpty() && $provision_requests->currentPage() != 1) {
            return redirect($request->fullUrlWithQuery(['page' => 1]));
        }

        $provision_requests->appends(array_filter($filters));
        $provision_requests->appends(array_filter(['order' => $request->get('order')]));
        $provision_requests->appends(array_filter(['direction' => $request->get('direction')]));

        return view('provision-request-index', [
            'request' => $request,
            'registry' => $registry,
            'category' => $category,
            'provider' => $provider,
            'function' => $function,
            'configuration' => $configuration,
            'provision_requests' => $provision_requests,
            'filters' => $filters,
            'order' => $order,
            'direction' => $direction,
        ]);
    }
}
