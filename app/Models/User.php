<?php

namespace App\Models;

use App\Models\Market\Order;
use App\Models\Market\OrderItem;
use App\Models\User\Role;
use App\Models\User\Address;
use App\Models\Ticket\Ticket;
use App\Models\Market\Payment;
use App\Models\Market\Product;
use App\Models\User\Permission;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Ticket\TicketAdmin;
use App\Models\User\Compare;
use Laravel\Jetstream\HasProfilePhoto;
use Nagy\LaravelRating\Traits\CanRate;
use Illuminate\Notifications\Notifiable;
use App\Traits\Permission\HasPermissionTrait;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasPermissionTrait;
    use CanRate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'status',
        'user_type',
        'activation',
        'profile_photo_path',
        'password',
        'email_verified_at',
        'mobile_verified_at',
        'national_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getFullNameAttribute()
    {
    return "{$this->first_name} {$this->last_name}";
    }


    public function ticketAdmin(){
        return $this->hasOne(TicketAdmin::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class, Order::class);
    }
    public function compare()
    {
        return $this->hasOne(Compare::class);
    }

    public function userProductPurchase()
    {
        $productId = collect();
        foreach (auth()->user()->orderItems as $orderItem) {
            $productId->push($orderItem->product_id);
        }
        $productId = $productId->unique();
        return $productId;
    }
}
