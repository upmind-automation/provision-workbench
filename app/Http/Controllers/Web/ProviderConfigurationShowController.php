<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Models\ProviderConfiguration;
use Illuminate\Http\Request;
use Upmind\ProvisionBase\Registry\Registry;

class ProviderConfigurationShowController extends Controller
{
    use InteractsWithRegistry;

    public function __invoke(Request $request, Registry $registry, ProviderConfiguration $configuration)
    {
        return view('provider-configuration-show', [
            'request' => $request,
            'registry' => $registry,
            'category' => $configuration->getProvider()->getCategory(),
            'provider' => $configuration->getProvider(),
            'configuration' => $configuration,
        ]);
    }
}
