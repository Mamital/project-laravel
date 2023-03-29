<?php

namespace App\Models\Market;

use App\Models\Content\Comment;
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
    public function values()
    {
        return $this->hasMany(CategoryValue::class, 'product_id');
    }
    public function AmazingSale()
    {
        return $this->hasMany(AmazingSale::class, 'product_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
