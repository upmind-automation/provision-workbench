<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Models\ProviderConfiguration;
use Illuminate\Http\Request;
use Upmind\ProvisionBase\Registry\Registry;

class ProviderShowController extends Controller
{
    use InteractsWithRegistry;

    public function __invoke(Request $request, Registry $registry)
    {
        $provider = $this->getProvider($registry, $request);

        $configurations = ProviderConfiguration::whereCategory($provider->getCategory())
            ->whereProvider($provider)
            ->get();

        return view('provider-show', [
            'request' => $request,
            'registry' => $registry,
            'category' => $provider->getCategory(),
            'provider' => $provider,
            'configurations' => $configurations,
        ]);
    }
}
