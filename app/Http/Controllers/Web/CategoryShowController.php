<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\InteractsWithRegistry;
use Illuminate\Http\Request;
use Upmind\ProvisionBase\Registry\Registry;

class CategoryShowController extends Controller
{
    use InteractsWithRegistry;

    public function __invoke(Request $request, Registry $registry)
    {
        $category = $this->getCategory($registry, $request);

        return view('category-show', [
            'request' => $request,
            'registry' => $registry,
            'category' => $category,
        ]);
    }
}
