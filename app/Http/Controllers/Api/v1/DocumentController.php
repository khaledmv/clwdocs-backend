<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DocumentController extends Controller
{
     public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = in_array((int) $request->per_page, [12, 24, 48, 96])
            ? (int) $request->per_page
            : 12;

        // $filters = $request->only([
        //     'document_type_id',
        //     'brand_id',
        //     'application_id',
        //     'solution_id',
        //     'product_category_id',
        //     'location_id',
        // ]);

        $filters = $request->only([
            'document_type',
            'brand',
            'application',
            'solution',
            'product_category',
            'location',
        ]);

        if ($request->filled('search')) {
            $ids = Document::search($request->search)
                ->when($filters, function ($query) use ($filters) {
                    foreach ($filters as $key => $value) {
                        if ($value) {
                            $query->where($key, $value);
                        }
                    }
                })
                ->keys();

            $documents = Document::published()
                ->whereIn('slug', $ids)
                ->with(['documentType', 'brand', 'application', 'solution', 'productCategory', 'location'])
                ->paginate($perPage);
        } else {
            $documents = Document::published()
                ->filter($filters)
                ->with(['documentType', 'brand', 'application', 'solution', 'productCategory', 'location'])
                ->latest('published_at')
                ->paginate($perPage);
        }

        return DocumentResource::collection($documents);
    }

    public function show(string $slug): DocumentResource
    {
        $document = Document::published()
            ->with(['documentType', 'brand', 'application', 'solution', 'productCategory', 'location'])
            ->where('slug', $slug)
            ->firstOrFail();

        return new DocumentResource($document);
    }

}
