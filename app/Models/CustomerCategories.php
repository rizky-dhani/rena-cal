<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class CustomerCategories extends Model
{
    protected $guarded = ['id'];

    /**
     * Generate a slug automatically when creating or updating a customer category
     */
    protected static function booted(): void
    {
        static::saving(function ($customerCategory) {
            $customerCategory->slug = Str::slug($customerCategory->name);
        });
    }
}
