<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use Illuminate\Http\Request;
use Upmind\ProvisionBase\Registry\Registry;

class ProviderConfigurationNewController extends Controller
{
    use InteractsWithRegistry;

    public function __invoke(Request $request, Registry $registry)
    {
        $provider = $this->getProvider($registry, $request);

        return view('provider-configuration-new', [
            'request' => $request,
            'registry' => $registry,
            'category' => $provider->getCategory(),
            'provider' => $provider,
        ]);
    }
}
