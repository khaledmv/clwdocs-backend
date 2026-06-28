<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Solution extends Model
{
   protected $fillable = ['name', 'slug'];

    protected static function booted(): void
    {
        static::creating(function (Solution $solution) {
            $solution->slug ??= Str::slug($solution->name);
        });
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
