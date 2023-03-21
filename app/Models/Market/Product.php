<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable = ['name', 'introduction', 'slug', 'image', 'status', 'weight', 'length', 'width', 'height','price', 'marketable', 'tags', 'sold_number', 'frozen_number','marketable_number', 'brand_id', 'category_id', 'published_at'];

    protected $casts = ['image' => 'array'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
    public function metas()
    {
        return $this->hasMany(ProductMeta::class, 'product_id');
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class, 'product_id');
    }
}
