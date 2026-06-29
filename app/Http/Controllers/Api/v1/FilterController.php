<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Brand;
use App\Models\DocumentType;
use App\Models\Location;
use App\Models\ProductCategory;
use App\Models\Solution;
use Illuminate\Http\JsonResponse;

class FilterController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'document_types'     => DocumentType::orderBy('name')->get(['id', 'name', 'slug']),
            'brands'             => Brand::orderBy('name')->get(['id', 'name', 'slug']),
            'applications'       => Application::orderBy('name')->get(['id', 'name', 'slug']),
            'solutions'          => Solution::orderBy('name')->get(['id', 'name', 'slug']),
            'product_categories' => ProductCategory::orderBy('name')->get(['id', 'name', 'slug']),
            'locations'          => Location::orderBy('name')->get(['id', 'name', 'slug']),
        ]);
    }
}
