<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Composer\UpmindPackages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Upmind\ProvisionBase\Registry\Registry;

class PackageIndexController extends Controller
{
    public function __invoke(Request $request, Registry $registry, UpmindPackages $packages)
    {
        return view('package-index', [
            'request' => $request,
            'registry' => $registry,
            'packages' => $packages->listVersions(),
        ]);
    }
}
