<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Brand extends Model
{
   protected $fillable = ['name', 'slug'];

    protected static function booted(): void
    {
        static::creating(function (Brand $brand) {
            $brand->slug ??= Str::slug($brand->name);
        });
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
