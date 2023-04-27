<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashPayment extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function payment()
    {
        return $this->morphOne('App\Models\Market\Payment', 'paymentable');
    }
}
