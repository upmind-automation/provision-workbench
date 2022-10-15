<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Http\Controllers\Traits\TransformsArrayDot;
use App\Services\ProviderConfigurationService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Upmind\ProvisionBase\Registry\Registry;

class ProviderConfigurationStoreController extends Controller
{
    use InteractsWithRegistry;
    use TransformsArrayDot;

    public function __invoke(Request $request, Registry $registry)
    {
        $provider = $this->getProvider($registry, $request);

        try {
            $service = new ProviderConfigurationService();
            $configuration = $service->create(
                $provider,
                $request->get('name'),
                $this->undot($request->get('field_values', []))
            );
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors(), 'field_values');
        }

        return redirect(route('provider-configuration-show', [
            'configuration' => $configuration,
            'created' => 1,
        ]));
    }
}
