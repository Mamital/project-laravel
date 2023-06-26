<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Market\Product;

class ProductCategory extends Model
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

    protected $casts = ['image' => 'array'];

    protected $fillable = ['name', 'description', 'slug', 'image', 'status', 'tags', 'parent_id', 'show_in_menu'];

    public function parent()
    {
        return $this->belongsTo($this)->with('parent');
    }
    public function children()
    {
        return $this->hasMany($this, 'parent_id')->with('children');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    public function properties()
    {
        return $this->hasMany(Property::class, 'category_id');
    }
}
