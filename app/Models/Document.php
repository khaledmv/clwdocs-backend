<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;


class Document extends Model
{
    use SoftDeletes, Searchable;

    protected $fillable = [
        'title', 'slug', 'description', 'pdf_content', 'meta_title', 'meta_description',
        'file_path', 'file_name', 'file_size', 'mime_type', 'thumbnail_path',
        'uploaded_by', 'is_published', 'published_at',
    ];

      protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'file_size'    => 'integer',
    ];


    
    protected static function booted(): void
    {
        static::creating(function (Document $document) {
            if ($document->slug) {
                return;
            }

            $base = Str::slug($document->title);
            $slug = $base;
            $i    = 2;

            while (static::withTrashed()->where('slug', $slug)->exists()) {
                $slug = "{$base}-{$i}";
                $i++;
            }

            $document->slug = $slug;
        });
    }


     // ─── Relationships ────────────────────────────────────────────────────────

    public function documentTypes(): BelongsToMany
    {
        return $this->belongsToMany(DocumentType::class, 'document_document_type');
    }

    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class, 'document_brand');
    }

    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class, 'document_application');
    }

    public function solutions(): BelongsToMany
    {
        return $this->belongsToMany(Solution::class, 'document_solution');
    }

    public function productCategories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'document_product_category');
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'document_location');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    public function getFileUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->file_path);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path
            ? Storage::disk('public')->url($this->thumbnail_path)
            : null;
    }

    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;

        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' B';
    }

    // ─── Tag helper ───────────────────────────────────────────────────────────

    public function allTags(): Collection
    {
        return collect([
            $this->documentTypes,
            $this->brands,
            $this->applications,
            $this->solutions,
            $this->productCategories,
            $this->locations,
        ])->flatMap(fn ($related) => $related->pluck('name'))->filter()->values();
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    // public function scopeFilter($query, array $filters)
    // {
    //     return $query
    //         ->when($filters['document_type_id'] ?? null, fn ($q, $v) => $q->where('document_type_id', $v))
    //         ->when($filters['brand_id'] ?? null, fn ($q, $v) => $q->where('brand_id', $v))
    //         ->when($filters['application_id'] ?? null, fn ($q, $v) => $q->where('application_id', $v))
    //         ->when($filters['solution_id'] ?? null, fn ($q, $v) => $q->where('solution_id', $v))
    //         ->when($filters['product_category_id'] ?? null, fn ($q, $v) => $q->where('product_category_id', $v))
    //         ->when($filters['location_id'] ?? null, fn ($q, $v) => $q->where('location_id', $v));
    // }


    // public function scopeFilter($query, array $filters)
    //         {
    //             return $query
    //                 ->when($filters['document_type'] ?? null, function ($q, $value) {
    //                     $q->whereHas('documentType', fn ($q) => $q->where('slug', $value));
    //                 })
    //                 ->when($filters['brand'] ?? null, function ($q, $value) {
    //                     $q->whereHas('brand', fn ($q) => $q->where('slug', $value));
    //                 })
    //                 ->when($filters['application'] ?? null, function ($q, $value) {
    //                     $q->whereHas('application', fn ($q) => $q->where('slug', $value));
    //                 })
    //                 ->when($filters['solution'] ?? null, function ($q, $value) {
    //                     $q->whereHas('solution', fn ($q) => $q->where('slug', $value));
    //                 })
    //                 ->when($filters['product_category'] ?? null, function ($q, $value) {
    //                     $q->whereHas('productCategory', fn ($q) => $q->where('slug', $value));
    //                 })
    //                 ->when($filters['location'] ?? null, function ($q, $value) {
    //                     $q->whereHas('location', fn ($q) => $q->where('slug', $value));
    //                 });
    //         }


    public function scopeFilter($query, array $filters)
        {
            return $query
                ->when($filters['document_type'] ?? null, function ($q, $value) {
                    $slugs = array_filter(array_map('trim', explode(',', $value)));

                    $q->whereHas('documentTypes', function ($q) use ($slugs) {
                        $q->whereIn('slug', $slugs);
                    });
                })

                ->when($filters['brand'] ?? null, function ($q, $value) {
                    $slugs = array_filter(array_map('trim', explode(',', $value)));

                    $q->whereHas('brands', function ($q) use ($slugs) {
                        $q->whereIn('slug', $slugs);
                    });
                })

                ->when($filters['application'] ?? null, function ($q, $value) {
                    $slugs = array_filter(array_map('trim', explode(',', $value)));

                    $q->whereHas('applications', function ($q) use ($slugs) {
                        $q->whereIn('slug', $slugs);
                    });
                })

                ->when($filters['solution'] ?? null, function ($q, $value) {
                    $slugs = array_filter(array_map('trim', explode(',', $value)));

                    $q->whereHas('solutions', function ($q) use ($slugs) {
                        $q->whereIn('slug', $slugs);
                    });
                })

                ->when($filters['product_category'] ?? null, function ($q, $value) {
                    $slugs = array_filter(array_map('trim', explode(',', $value)));

                    $q->whereHas('productCategories', function ($q) use ($slugs) {
                        $q->whereIn('slug', $slugs);
                    });
                })

                ->when($filters['location'] ?? null, function ($q, $value) {
                    $slugs = array_filter(array_map('trim', explode(',', $value)));

                    $q->whereHas('locations', function ($q) use ($slugs) {
                        $q->whereIn('slug', $slugs);
                    });
                });
        }

    // ─── Scout ────────────────────────────────────────────────────────────────

    public function toSearchableArray(): array
    {
        return [
            'id'                    => $this->id,
            'title'                 => $this->title,
            'slug'                  => $this->slug,
            'description'           => $this->description,
            'pdf_content'           => $this->pdf_content,
            'document_types'        => $this->documentTypes->pluck('name')->all(),
            'document_type_ids'     => $this->documentTypes->pluck('id')->all(),
            'brands'                => $this->brands->pluck('name')->all(),
            'brand_ids'             => $this->brands->pluck('id')->all(),
            'applications'          => $this->applications->pluck('name')->all(),
            'application_ids'       => $this->applications->pluck('id')->all(),
            'solutions'             => $this->solutions->pluck('name')->all(),
            'solution_ids'          => $this->solutions->pluck('id')->all(),
            'product_categories'    => $this->productCategories->pluck('name')->all(),
            'product_category_ids'  => $this->productCategories->pluck('id')->all(),
            'locations'             => $this->locations->pluck('name')->all(),
            'location_ids'          => $this->locations->pluck('id')->all(),
            'file_name' => $this->file_name,
            'tags' => $this->allTags()->all(),
            'published_at'        => $this->published_at?->timestamp,
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return $this->is_published;
    }

    public function getScoutKey(): string
    {
        return $this->slug;
    }

    public function getScoutKeyName(): string
    {
        return 'slug';
    }
}
