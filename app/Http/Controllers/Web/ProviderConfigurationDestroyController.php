<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Models\ProviderConfiguration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ProviderConfigurationDestroyController extends Controller
{
    use InteractsWithRegistry;

    public function __construct(
        private readonly Redirector $redirector
    ) {
    }

    public function __invoke(Request $request, ProviderConfiguration $configuration): RedirectResponse
    {
        $configuration->delete();

        return $this->redirector->route('provider-show', [
            'category_code' => $configuration->category_code,
            'provider_code' => $configuration->provider_code,
            'configuration_deleted' => 1
        ]);
    }
}
