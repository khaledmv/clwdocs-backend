<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Meilisearch\Client;

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

    // private function searchDocuments( string $search, array $filters, int $perPage ) {
    //     // $ids = Document::search($search)
    //     //     ->when($filters, function ($query) use ($filters) {
    //     //         foreach ($filters as $key => $value) {
    //     //             $query->where($key, $value);
    //     //         }
    //     //     })
    //     //     ->keys();

    //     $client = new Client(
    //         config('scout.meilisearch.host'),
    //         config('scout.meilisearch.key')
    //     );

    //     $index = $client->index('documents');

    //     $options = [
    //         'attributesToHighlight' => ['pdf_text'],
    //         'attributesToCrop' => ['pdf_text'],
    //         'cropLength' => 25,
    //         'highlightPreTag' => '<mark>',
    //         'highlightPostTag' => '</mark>',
    //     ];

    //     if ($ids->isEmpty()) {
    //         return Document::query()
    //             ->whereRaw('1 = 0')
    //             ->paginate($perPage);
    //     }

    //     return Document::published()
    //         ->whereIn('slug', $ids)
    //         ->orderByRaw(
    //             "FIELD(slug, '" . implode("','", $ids->all()) . "')"
    //         )
    //         ->with(self::RELATIONS)
    //         ->paginate($perPage);
    // }


    private function searchDocuments(string $search, array $filters, int $perPage)
{
    $client = new Client(
        config('scout.meilisearch.host'),
        config('scout.meilisearch.key')
    );

    $index = $client->index((new Document())->searchableAs());

    // Build Meilisearch filter
    $meiliFilters = [];

    foreach ($filters as $key => $value) {
        $meiliFilters[] = sprintf('%s = %d', $key, (int) $value);
    }

    $searchOptions = [
        'attributesToHighlight' => [
            'title',
            'description',
            'pdf_content',
        ],

        'attributesToCrop' => [
            'description',
            'pdf_content',
        ],

        'cropLength' => 30,

        'highlightPreTag' => '<mark>',
        'highlightPostTag' => '</mark>',
    ];

    if (! empty($meiliFilters)) {
        $searchOptions['filter'] = implode(' AND ', $meiliFilters);
    }

    $results = $index->search($search, $searchOptions);

    $hits = $results->getHits();

    if (empty($hits)) {
        return Document::query()
            ->whereRaw('1 = 0')
            ->paginate($perPage);
    }

    $ids = collect($hits)->pluck('slug');

    $snippets = collect($hits)
        ->mapWithKeys(function ($hit) {

            return [
                $hit['slug'] => $hit['_formatted']['pdf_content']
                    ?? $hit['_formatted']['description']
                    ?? null,
            ];
        });

    $documents = Document::published()
        ->whereIn('slug', $ids)
        ->with(self::RELATIONS)
        ->get()
        ->sortBy(fn ($doc) => $ids->search($doc->slug))
        ->values();

    $documents->each(function ($document) use ($snippets) {
        $document->search_snippet = $snippets[$document->slug] ?? null;
    });

    return new \Illuminate\Pagination\LengthAwarePaginator(
        $documents,
        $documents->count(),
        $perPage,
        request()->input('page', 1),
        [
            'path' => request()->url(),
            'query' => request()->query(),
        ]
    );
}
}