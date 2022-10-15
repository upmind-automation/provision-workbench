<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ProvisionRequest;
use App\Services\ProvisionRequestService;
use Illuminate\Http\Request;

class ProvisionRequestDestroyController extends Controller
{
    public function __invoke(Request $request, ProvisionRequest $provision_request)
    {
        $service = new ProvisionRequestService();
        $service->delete($provision_request);

        return redirect(route('provision-request-index'));
    }
}
