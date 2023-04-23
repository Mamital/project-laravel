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

    protected $guarded = ['id'];

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

    public function getPaymentTypeValueAttribute()
    {
        switch ($this->payment_type){
            case 0:
                $result = 'آنلاین';
                break ;
            case 1:
                $result = 'آفلاین';
                break ;
            case 2:
                $result = 'در محل';
                break ;
        }
        return $result;
    }
    public function getPaymentStatusValueAttribute()
    {
        switch ($this->payment_status){
            case 0:
                $result = 'پرداخت نشده';
                break ;
            case 1:
                $result = 'پرداخت شده';
                break ;
            case 2:
                $result = 'باطل شده';
                break ;
            case 3:
                $result = 'برگشت داده شده';
                break ;
        }
        return $result;
    }
    public function getDeliveryStatusValueAttribute()
    {
        switch ($this->delivery_status){
            case 0:
                $result = 'ارسال نشده';
                break ;
            case 1:
                $result = 'در حال ارسال';
                break ;
            case 2:
                $result = 'ارسال شده';
                break ;
            case 3:
                $result = 'تحویل داده شده';
                break ;
        }
        return $result;
    }
    public function getOrderStatusValueAttribute()
    {
        switch ($this->order_status){
            case 1:
                $result = 'در انتظار تایید';
                break ;
            case 2:
                $result = 'تایید نشده';
                break ;
            case 3:
                $result = 'تایید شده';
                break ;
            case 4:
                $result = 'باطل شده';
                break ;
            case 5:
                $result = 'مرجوع شده';
                break ;
            case 6:
                $result = 'بررسی نشده';
                break ;
        }
        return $result;
    }


}
