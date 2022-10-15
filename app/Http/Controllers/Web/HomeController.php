<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Upmind\ProvisionBase\Registry\Registry;

class HomeController extends Controller
{
    public function __invoke(Request $request, Registry $registry)
    {
        return view('home', [
            'request' => $request,
            'registry' => $registry,
        ]);
    }
}
