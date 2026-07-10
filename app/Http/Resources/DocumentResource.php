<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class DocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'title'              => $this->title,
            'slug'               => $this->slug,
            'meta_title'         => $this->meta_title,
            'meta_description'   => $this->meta_description,
            'description'        => $this->description,
            'file_url'           => $this->file_url,
            'file_name'          => $this->file_name,
            'file_size_human'    => $this->file_size_human,
            'thumbnail_url'      => $this->thumbnail_url,
            'is_published'       => $this->is_published,
            'published_at'       => $this->published_at?->toDateString(),
            'created_at'         => $this->created_at->toISOString(),

            'search_snippet'     => $this->when(
                                        request()->filled('search'),
                                        $this->search_snippet
                                    ),

            'document_types'     => $this->whenLoaded(
                'documentTypes',
                fn () => $this->transformTags($this->documentTypes)
            ),

            'brands'             => $this->whenLoaded(
                'brands',
                fn () => $this->transformTags($this->brands)
            ),

            'applications'       => $this->whenLoaded(
                'applications',
                fn () => $this->transformTags($this->applications)
            ),

            'solutions'          => $this->whenLoaded(
                'solutions',
                fn () => $this->transformTags($this->solutions)
            ),

            'product_categories' => $this->whenLoaded(
                'productCategories',
                fn () => $this->transformTags($this->productCategories)
            ),

            'locations'          => $this->whenLoaded(
                'locations',
                fn () => $this->transformTags($this->locations)
            ),

            'all_tags'           => $this->allTags()->values(),
        ];
    }

    private function transformTags(Collection $items): Collection
    {
        return $items->map(fn ($item) => [
            'id'   => $item->id,
            'name' => $item->name,
            'slug' => $item->slug,
        ])->values();
    }
}