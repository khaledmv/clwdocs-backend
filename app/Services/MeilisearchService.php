<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Pagination\LengthAwarePaginator;
use Meilisearch\Client;

class MeilisearchService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client(
            config('scout.meilisearch.host'),
            config('scout.meilisearch.key')
        );
    }

    protected function index()
    {
        return $this->client->index(
            (new Document())->searchableAs()
        );
    }

    public function search( string $query, array $filters = [], int $page = 1, int $perPage = 12 ): LengthAwarePaginator
        {
            $options = [
                'page' => $page,
                'hitsPerPage' => $perPage,

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

              $filter = $this->buildFilter($filters);

                if ($filter !== null) {
                    $options['filter'] = $filter;
                }

            $results = $this->index()->search($query, $options);

            $hits = collect($results->getHits());
           
            $slugs = $hits
                    ->pluck('slug')
                    ->filter()
                    ->values();

            if ($slugs->isEmpty()) {
                    return new LengthAwarePaginator(
                        [],
                        0,
                        $perPage,
                        $page
                    );
                }

            $documents = Document::published()
                ->whereIn('slug', $slugs)
                ->with([
                    'documentTypes',
                    'brands',
                    'applications',
                    'solutions',
                    'productCategories',
                    'locations',
                ])
                ->get()
                ->keyBy('slug');

            $collection = $hits
                ->map(function ($hit) use ($documents) {

                    $document = $documents->get($hit['slug']);

                    if (! $document) {
                        return null;
                    }

                    $document->search_snippet =
                        $hit['_formatted']['pdf_content']
                        ?? $hit['_formatted']['description']
                        ?? null;

                    return $document;
                })
                ->filter()
                ->values();

                return new LengthAwarePaginator(
                    $collection,
                    $results->getTotalHits(),
                    $perPage,
                    $page,
                    [
                        'path' => request()->url(),
                        'query' => request()->query(),
                    ]
                );
            

            // throw new \RuntimeException('Not implemented yet.');
        }

    protected function buildFilter(array $filters): ?string
     {
            if (empty($filters)) {
                return null;
            }

            $filterMap = [
                'document_type'   => 'document_type_slugs',
                'brand'           => 'brand_slugs',
                'application'     => 'application_slugs',
                'solution'        => 'solution_slugs',
                'product_category'=> 'product_category_slugs',
                'location'        => 'location_slugs',
            ];

            $expressions = [];

            foreach ($filters as $key => $value) {
                if (! isset($filterMap[$key])) {
                    continue;
                }

                $field = $filterMap[$key];

                $expressions[] = sprintf(
                    '%s = "%s"',
                    $field,
                    addslashes($value)
                );
            }

            return empty($expressions)
                ? null
                : implode(' AND ', $expressions);
        }
}