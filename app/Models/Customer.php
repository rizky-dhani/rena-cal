<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Generate a slug automatically when creating or updating a customer
     */
    protected static function booted(): void
    {
        static::saving(function ($customer) {
            $customer->slug = Str::slug($customer->name);
        });
    }

    /**
     * A customer has many users (Hospital Users)
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * A customer has many devices
     */
    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    /**
     * A customer has many inventories
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * A customer belongs to a category
     */
    public function category()
    {
        return $this->belongsTo(CustomerCategory::class, 'categories_id');
    }
}
