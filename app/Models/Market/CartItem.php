<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function color()
    {
        return $this->belongsTo(ProductColor::class);
    }
    public function guarantee()
    {
        return $this->belongsTo(Guarantee::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    // product + color + guarantee
    public function cartItemProductPrice()
    {
        $product_price = $this->product->price;
        $gurantee_price = empty($this->guarantee_id) ? 0 : $this->guarantee->price_increase;
        $color_price = empty($this->color_id) ? 0 : $this->color->price_increase;
        return $product_price + $gurantee_price + $color_price;
    }

    //product * (discount / 100)
    public function cartItemProductDiscount()
    {
        $product_price = $this->cartItemProductPrice();
        $discount = empty($this->product->activeAmazingSales()) ? 0 : $this->product->activeAmazingSales()->percentage;
        return $product_price * ($discount / 100);
    }

    //number * (product + guarantee + color - discount)
    public function cartItemFinalPrice()
    {
        $productPrice = $this->cartItemProductPrice();
        $discount = $this->cartItemProductDiscount();
        return $this->number * ($productPrice - $discount);
    }

    //number * discount
    public function cartItemFinalDiscount()
    {
        $discount = $this->cartItemProductDiscount();
        return $this->number * $discount;
    }

}
