<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    protected $table = 'category_attributes';
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'category_id', 'type', 'unit'];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
    public function values()
    {
        return $this->hasMany(CategoryValue::class, 'category_attribute_id');
    }
}
