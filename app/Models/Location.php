<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;


class Location extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function booted(): void
    {
        static::creating(function (Location $location) {
            $location->slug ??= Str::slug($location->name);
        });
    }

     public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
