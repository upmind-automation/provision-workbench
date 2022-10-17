<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Http\Controllers\Traits\TransformsArrayDot;
use App\Models\ProviderConfiguration;
use App\Services\ProvisionRequestService;
use Illuminate\Http\Request;

class ProvisionRequestStoreController extends Controller
{
    use InteractsWithRegistry;
    use TransformsArrayDot;

    public function __invoke(Request $request)
    {
        $configuration = ProviderConfiguration::findOrFail($request->get('configuration_id'));
        if ($category = $configuration->getCategory()) {
            $function = $category->getFunction($request->get('function_name'));
        }

        if (!isset($function)) {
            return redirect()->back()->withErrors([
                'function_name' => sprintf('Function %s not found', $request->get('function_name')),
            ]);
        }

        $parameters = $this->undot($request->get('parameter_data', []));

        $service = new ProvisionRequestService();
        $provisionRequest = $service->create($function, $configuration, $parameters);

        return redirect(
            route('provision-request-show', ['provision_request' => $provisionRequest])
        );
    }
}
