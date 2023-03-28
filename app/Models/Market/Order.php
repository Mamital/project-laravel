<?php

namespace App\Models\Market;

use App\Models\User;
use App\Models\User\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public function delivery(){

    return $this->belongsTo(Delivery::class, 'delivery_id');

    }
    public function payment(){

    return $this->belongsTo(Payment::class, 'payment_id');
    
    }
    public function address(){

    return $this->belongsTo(Address::class, 'address_id');
    
    }
    public function user(){

    return $this->belongsTo(User::class, 'user_id');
    
    }
    public function copan(){

    return $this->belongsTo(Copan::class);
    
    }
    public function commonDiscount(){

    return $this->belongsTo(CommonDiscount::class);
    
    }

    public function orderItems(){

    return $this->hasMany(OrderItem::class);
    
    }


}
