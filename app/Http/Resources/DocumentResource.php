<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'slug'             => $this->slug,
            'description'      => $this->description,
            'file_url'         => $this->file_url,
            'file_name'        => $this->file_name,
            'file_size_human'  => $this->file_size_human,
            'thumbnail_url'    => $this->thumbnail_url,
            'is_published'     => $this->is_published,
            'published_at'     => $this->published_at?->toDateString(),
            'created_at'       => $this->created_at->toISOString(),
            'document_type'    => $this->whenLoaded('documentType', fn () => [
                'id'   => $this->documentType->id,
                'name' => $this->documentType->name,
                'slug' => $this->documentType->slug,
            ]),
            'brand'            => $this->whenLoaded('brand', fn () => $this->brand ? [
                'id'   => $this->brand->id,
                'name' => $this->brand->name,
                'slug' => $this->brand->slug,
            ] : null),
            'application'      => $this->whenLoaded('application', fn () => $this->application ? [
                'id'   => $this->application->id,
                'name' => $this->application->name,
                'slug' => $this->application->slug,
            ] : null),
            'solution'         => $this->whenLoaded('solution', fn () => $this->solution ? [
                'id'   => $this->solution->id,
                'name' => $this->solution->name,
                'slug' => $this->solution->slug,
            ] : null),
            'product_category' => $this->whenLoaded('productCategory', fn () => $this->productCategory ? [
                'id'   => $this->productCategory->id,
                'name' => $this->productCategory->name,
                'slug' => $this->productCategory->slug,
            ] : null),
            'location'         => $this->whenLoaded('location', fn () => $this->location ? [
                'id'   => $this->location->id,
                'name' => $this->location->name,
                'slug' => $this->location->slug,
            ] : null),
            'all_tags'             => $this->allTags()->values(),
        ];
    }
}
