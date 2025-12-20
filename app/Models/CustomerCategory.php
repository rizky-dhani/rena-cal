<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Represents a customer category in the system.
 */
class CustomerCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Generate a slug automatically when creating or updating a customer category
     */
    protected static function booted(): void
    {
        static::saving(function (self $customerCategory) {
            $customerCategory->slug = Str::slug($customerCategory->name);
        });
    }

    /**
     * A customer category has many customers
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'categories_id');
    }
}
