<?php

namespace App\Models\Market;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Content\Comment;
use App\Models\User\Compare;
use Illuminate\Database\Eloquent\Model;
use Nagy\LaravelRating\Traits\Rateable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes, Sluggable, Rateable;

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
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'product_id');
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class, 'product_id');
    }
    public function values()
    {
        return $this->hasMany(CategoryValue::class, 'product_id');
    }
    public function amazingSales()
    {
        return $this->hasMany(AmazingSale::class, 'product_id');
    }
    public function guarantees()
    {
        return $this->hasMany(Guarantee::class, 'product_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function compares()
    {
        return $this->belongsToMany(Compare::class);
    }

    public function activeAmazingSales()
    {
        return $this->amazingSales()->where('start_date', '<', Carbon::now())->where('end_date', '>', Carbon::now())->first();
    }

    public function activeComments()
    {
        return $this->comments()->where('approved', 1)->get();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function amazingSaleDiscount()
    {
        if($this->activeAmazingSales())
        {
            return $this->price * $this->activeAmazingSales()->percentage / 100 ;
        }else{
            return 0;
        }
    }
}
