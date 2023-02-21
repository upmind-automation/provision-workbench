<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Http\Controllers\Traits\TransformsArrayDot;
use App\Models\ProviderConfiguration;
use App\Models\ProvisionRequest;
use App\Services\ProvisionRequestService;
use Illuminate\Http\Request;

class ProvisionRequestRetryController extends Controller
{
    use InteractsWithRegistry;
    use TransformsArrayDot;

    public function __invoke(Request $request, ProvisionRequest $provision_request)
    {
        $configuration = $provision_request->configuration;

        if (!isset($configuration)) {
            return redirect(route('provision-request-new', ['provision_request_id' => $provision_request->id]))
                ->withErrors([
                    'configuration_id' => 'Configuration not found',
                ]);
        }

        $function = $provision_request->getFunction();

        if (!isset($function)) {
            return redirect(route('provision-request-new', ['provision_request_id' => $provision_request->id]))
                ->withErrors([
                    'function_name' => sprintf('Function %s not found', $provision_request->function_name),
                ]);
        }

        $parameters = $provision_request->parameter_data;

        $service = new ProvisionRequestService();
        $retriedRequest = $service->create($function, $configuration, $parameters);

        return redirect(
            route('provision-request-show', ['provision_request' => $retriedRequest])
        );
    }
}
