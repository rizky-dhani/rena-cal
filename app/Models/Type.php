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

            $query = static::where('slug', $slug)->where('brand_id', $type->brand_id);
            if ($type->exists) {
                $query->where('id', '!=', $type->id);
            }

            $count = $query->count();
            if ($count > 0) {
                $slug = $slug.'-'.($count + 1);
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
