<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;


class Document extends Model
{
    use SoftDeletes, Searchable;

    protected $fillable = [
        'title', 'slug', 'description','meta_title', 'meta_description',
        'document_type_id', 'brand_id', 'application_id',
        'solution_id', 'product_category_id', 'location_id',
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

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function solution(): BelongsTo
    {
        return $this->belongsTo(Solution::class);
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
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
            $this->documentType?->name,
            $this->brand?->name,
            $this->application?->name,
            $this->solution?->name,
            $this->productCategory?->name,
            $this->location?->name,
        ])->filter();
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['document_type_id'] ?? null, fn ($q, $v) => $q->where('document_type_id', $v))
            ->when($filters['brand_id'] ?? null, fn ($q, $v) => $q->where('brand_id', $v))
            ->when($filters['application_id'] ?? null, fn ($q, $v) => $q->where('application_id', $v))
            ->when($filters['solution_id'] ?? null, fn ($q, $v) => $q->where('solution_id', $v))
            ->when($filters['product_category_id'] ?? null, fn ($q, $v) => $q->where('product_category_id', $v))
            ->when($filters['location_id'] ?? null, fn ($q, $v) => $q->where('location_id', $v));
    }

    // ─── Scout ────────────────────────────────────────────────────────────────

    public function toSearchableArray(): array
    {
        return [
            'id'                  => $this->id,
            'title'               => $this->title,
            'slug'                => $this->slug,
            'description'         => $this->description,
            'document_type'       => $this->documentType?->name,
            'document_type_id'    => $this->document_type_id,
            'brand'               => $this->brand?->name,
            'brand_id'            => $this->brand_id,
            'application'         => $this->application?->name,
            'application_id'      => $this->application_id,
            'solution'            => $this->solution?->name,
            'solution_id'         => $this->solution_id,
            'product_category'    => $this->productCategory?->name,
            'product_category_id' => $this->product_category_id,
            'location'            => $this->location?->name,
            'location_id'         => $this->location_id,
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
