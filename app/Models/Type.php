<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Type extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Automatic slug generation based on name change
     */
    protected static function booted()
    {
        static::saving(function ($type) {
            $slug = Str::slug($type->name);
            if (empty($slug)) {
                $slug = 'type-'.Str::random(8);
            }
            $type->slug = $slug;
        });
    }

    /**
     * A type belongs to a brand
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * A type has many devices
     */
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
