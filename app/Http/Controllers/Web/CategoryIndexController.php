<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Upmind\ProvisionBase\Registry\Registry;

class CategoryIndexController extends Controller
{
    public function __invoke(Request $request, Registry $registry)
    {
        return view('category-index', [
            'request' => $request,
            'registry' => $registry,
            'categories' => $registry->getCategories(),
        ]);
    }
}
