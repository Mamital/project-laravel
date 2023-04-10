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
                $result = 'اسلاید';
                break;
            case 1:
                $result = 'کنار بالا (اصلی)';
                break;
            case 2:
                $result = 'کنار پایین(اصلی)';
                break;
            case 3:
                $result = 'تبلیغالی وسط (اصلی)';
                break;
            case 4:
                $result = 'تبلیغاتی پایین (اصلی)';
                break;
        }
        return $result;
    }
}
