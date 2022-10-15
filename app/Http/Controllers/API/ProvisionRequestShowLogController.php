<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Models\ProvisionRequest;
use App\Services\ProvisionRequestService;
use Illuminate\Http\Request;

class ProvisionRequestShowLogController extends Controller
{
    use InteractsWithRegistry;

    public function __invoke(Request $request, ProvisionRequest $provision_request)
    {
        $service = new ProvisionRequestService();

        return response()->json([
            'log' => $service->getLogs($provision_request),
        ]);
    }
}
