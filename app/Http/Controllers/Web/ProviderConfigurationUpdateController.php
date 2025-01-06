<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Http\Controllers\Traits\TransformsArrayDot;
use App\Http\Requests\ProviderConfigurationUpdateRequest;
use App\Models\ProviderConfiguration;
use App\Services\ProviderConfigurationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ProviderConfigurationUpdateController extends Controller
{
    use InteractsWithRegistry;
    use TransformsArrayDot;

    public function __construct(
        private readonly ProviderConfigurationService $service,
        private readonly Redirector $redirector
    ) {
    }

    public function __invoke(
        ProviderConfigurationUpdateRequest $request,
        ProviderConfiguration $configuration
    ): RedirectResponse {
        $configuration = $this->service->update(
            $configuration,
            $request->get('name'),
            $this->undot($request->get('field_values', []))
        );

        return $this->redirector->route('provider-configuration-show', [
            'configuration' => $configuration,
            'updated' => 1,
        ]);
    }
}
