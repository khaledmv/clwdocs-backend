<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class DocumentType extends Model
{
   protected $fillable = ['name', 'slug'];

    protected static function booted(): void
    {
        static::creating(function (DocumentType $documentType) {
            $documentType->slug ??= Str::slug($documentType->name);
        });
    }

     public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
