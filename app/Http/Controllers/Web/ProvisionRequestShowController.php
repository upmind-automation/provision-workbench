<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Models\ProvisionRequest;
use App\Services\ProvisionRequestService;
use Illuminate\Http\Request;
use Upmind\ProvisionBase\Registry\Registry;

class ProvisionRequestShowController extends Controller
{
    use InteractsWithRegistry;

    public function __invoke(Request $request, Registry $registry, ProvisionRequest $provision_request)
    {
        return view('provision-request-show', [
            'request' => $request,
            'registry' => $registry,
            'category' => $provision_request->getCategory(),
            'provider' => $provision_request->getProvider(),
            'configuration' => $provision_request->configuration,
            'function' => $provision_request->getFunction(),
            'provision_request' => $provision_request,
            'logs' => (new ProvisionRequestService())->getLogs($provision_request),
        ]);
    }
}
