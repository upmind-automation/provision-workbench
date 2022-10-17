<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Models\ProvisionRequest;
use App\Services\ProvisionRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Upmind\ProvisionBase\Registry\Registry;

class ProvisionRequestShowController extends Controller
{
    use InteractsWithRegistry;

    public function __invoke(Request $request, Registry $registry, ProvisionRequest $provision_request)
    {
        $result = $provision_request->getResult();

        if ($result) {
            $result_data = $result->getData();
            $result_debug = $result->getDebug();
        }

        if ($function = $provision_request->getFunction()) {
            $resultDataValidator = Validator::make(
                $result_data,
                $function->getReturn()->getRules()->expand()
            );

            $result_data_rules = $resultDataValidator->getRules();
        }

        return view('provision-request-show', [
            'request' => $request,
            'registry' => $registry,
            'category' => $provision_request->getCategory(),
            'provider' => $provision_request->getProvider(),
            'configuration' => $provision_request->configuration,
            'function' => $function,
            'provision_request' => $provision_request,
            'result_data_rules' => $result_data_rules ?? [],
            'result_data' => $result_data ?? [],
            'result_debug' => $result_debug ?? [],
            'logs' => (new ProvisionRequestService())->getLogs($provision_request),
        ]);
    }
}
