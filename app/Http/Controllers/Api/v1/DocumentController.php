<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DocumentController extends Controller
{
    private const FILTERS = [
        'document_type',
        'brand',
        'application',
        'solution',
        'product_category',
        'location',
    ];

    private const RELATIONS = [
        'documentTypes',
        'brands',
        'applications',
        'solutions',
        'productCategories',
        'locations',
    ];

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = in_array((int) $request->input('per_page'), [12, 24, 48, 96], true)
            ? (int) $request->input('per_page')
            : 12;

        $filters = array_filter(
            $request->only(self::FILTERS),
            fn ($value) => filled($value)
        );

        if ($request->filled('search')) {
            $documents = $this->searchDocuments(
                $request->string('search')->toString(),
                $filters,
                $perPage
            );
        } else {
            $documents = Document::published()
                ->filter($filters)
                ->with(self::RELATIONS)
                ->latest('published_at')
                ->paginate($perPage);
        }

        return DocumentResource::collection($documents);
    }

    public function show(string $slug): DocumentResource
    {
        $document = Document::published()
            ->with(self::RELATIONS)
            ->where('slug', $slug)
            ->firstOrFail();

        return new DocumentResource($document);
    }

    private function searchDocuments(
        string $search,
        array $filters,
        int $perPage
    ) {
        $ids = Document::search($search)
            ->when($filters, function ($query) use ($filters) {
                foreach ($filters as $key => $value) {
                    $query->where($key, $value);
                }
            })
            ->keys();

        if ($ids->isEmpty()) {
            return Document::query()
                ->whereRaw('1 = 0')
                ->paginate($perPage);
        }

        return Document::published()
            ->whereIn('slug', $ids)
            ->orderByRaw(
                "FIELD(slug, '" . implode("','", $ids->all()) . "')"
            )
            ->with(self::RELATIONS)
            ->paginate($perPage);
    }
}