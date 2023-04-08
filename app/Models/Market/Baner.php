<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Baner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'url', 'image', 'status', 'position'];
    
    public function getPositionValueAttribute()
    {
        switch ($this->position) {
            case 0:
                $result = 'اصلی';
                break;
            case 1:
                $result = 'کنار بالا';
                break;
            case 2:
                $result = 'کنار پایین';
                break;
        }
        return $result;
    }
}
