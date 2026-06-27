<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
   protected $fillable = ['name', 'slug'];

    protected static function booted(): void
    {
        static::creating(function (ProductCategory $productCategory) {
            $productCategory->slug ??= Str::slug($productCategory->name);
        });
    }
}
