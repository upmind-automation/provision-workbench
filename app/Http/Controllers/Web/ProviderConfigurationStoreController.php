<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Http\Controllers\Traits\TransformsArrayDot;
use App\Http\Requests\ProviderConfigurationStoreRequest;
use App\Services\ProviderConfigurationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Upmind\ProvisionBase\Registry\Registry;

class ProviderConfigurationStoreController extends Controller
{
    use InteractsWithRegistry;
    use TransformsArrayDot;

    public function __construct(
        private readonly ProviderConfigurationService $service,
        private readonly Redirector $redirector
    ) {
    }

    public function __invoke(ProviderConfigurationStoreRequest $request, Registry $registry): RedirectResponse
    {
        /** @var \Upmind\ProvisionBase\Registry\Data\ProviderRegister $provider */
        $provider = $this->getProvider($registry, $request);

        $configuration = $this->service->create(
            $provider,
            $request->get('name'),
            $this->undot($request->get('field_values', []))
        );

        return $this->redirector->route('provider-configuration-show', [
            'configuration' => $configuration,
            'created' => 1,
        ]);
    }
}
