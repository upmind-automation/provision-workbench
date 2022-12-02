<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use App\Http\Controllers\Traits\TransformsArrayDot;
use App\Models\ProviderConfiguration;
use App\Services\ProviderConfigurationService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProviderConfigurationUpdateController extends Controller
{
    use InteractsWithRegistry;
    use TransformsArrayDot;

    public function __invoke(Request $request, ProviderConfiguration $configuration)
    {
        try {
            $service = new ProviderConfigurationService();
            $service->update(
                $configuration,
                $request->get('name'),
                $this->undot($request->get('field_values', []))
            );
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors(), 'field_values');
        }

        return redirect(route('provider-configuration-show', [
            'configuration' => $configuration,
            'updated' => 1
        ]));
    }
}
