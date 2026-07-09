<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Application extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function booted(): void
    {
        static::creating(function (Application $application) {
            $application->slug ??= Str::slug($application->name);
        });
    }

   public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'document_application');
    }
}
