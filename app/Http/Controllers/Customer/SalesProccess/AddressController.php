<?php

namespace App\Http\Controllers\Customer\SalesProccess;

use App\Models\User\City;
use App\Models\User\Address;
use App\Models\User\Province;
use App\Models\Market\CartItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\SalesProccess\ChooseAddressAndDelivery;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Customer\SalesProccess\StoreAddressRequest;
use App\Http\Requests\Customer\SalesProccess\UpdateAddress;
use App\Models\Market\CommonDiscount;
use App\Models\Market\Delivery;
use App\Models\Market\Order;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function addressAndDelivery()
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $provinces = Province::all();
        $addresses = Address::where('user_id', $user->id)->get();
        $deliveries = Delivery::where('status', 1)->get();
        if (empty(CartItem::where('user_id', $user->id)->count())) {
            return redirect()->route('home.sales-proccess.profile-completion');
        }

        return view('customer.sales-proccess.address', compact('cartItems', 'addresses', 'provinces', 'deliveries'));
    }

    public function getCities(Province $province)
    {
        $cities = City::where('province_id', $province->id)->get();
        if ($cities != null) {
            return response()->json(['status' => 1, 'cities' => $cities]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function addAddress(StoreAddressRequest $request)
    {
        $inputs = $request->all();
        $postalCode = convertArabicToEnglish($request->postal_code);
        $postalCode = convertPersianToEnglish($postalCode);

        $inputs['postal_code'] = $postalCode;
        $inputs['user_id'] = Auth::user()->id;

        $address = Address::create($inputs);

        return back();

        

    }
    public function updateAddress(Address $address, UpdateAddress $request)
    {
        $inputs = $request->all();
        $postalCode = convertArabicToEnglish($request->postal_code);
        $postalCode = convertPersianToEnglish($postalCode);

        $inputs['postal_code'] = $postalCode;
        $inputs['user_id'] = Auth::user()->id;

        $address->update($inputs);

        return back();

    }
    public function chooseAddressDelivery(ChooseAddressAndDelivery $request)
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $inputs = $request->all();

        $totalProductPrice = 0;
        $totalDiscount = 0;
        $totalFinalprice = 0;
        $totalFinalDiscountPrice = 0;
        
        foreach($cartItems as $cartItem)
        {
            $totalProductPrice += $cartItem->cartItemProductPrice();
            $totalDiscount += $cartItem->cartItemProductDiscount();
            $totalFinalprice += $cartItem->cartItemFinalPrice();
            $totalFinalDiscountPrice += $cartItem->cartItemFinalDiscount();
        }
        
        $commonDiscount = CommonDiscount::where([
            ['status', 1],
            ['start_date', '<', now()],
            ['end_date', '>', now()],
            ])->first();
            
            if($commonDiscount)
            {
                $commonPercentageDiscountAmount = $totalFinalprice * ($commonDiscount->percentage / 100) ;
                
                if($commonPercentageDiscountAmount >= $commonDiscount->discount_ceiling)
                {
                    $commonPercentageDiscountAmount = $commonDiscount->discount_ceiling ;
                }
                if($totalFinalprice >= $commonDiscount->minimal_order_amount)
                {
                    $totalFinalprice = $totalFinalprice - $commonPercentageDiscountAmount;
                }else{
                $commonPercentageDiscountAmount = 0 ;
                }
            }else{
            $commonPercentageDiscountAmount = null ;
            }
            
            
        $inputs['user_id'] = $user->id;
        $inputs['order_final_amount'] = $totalFinalprice;
        $inputs['order_discount_amount'] = $totalFinalDiscountPrice;
        $inputs['order_common_discount_amount'] = $commonPercentageDiscountAmount;
        $inputs['order_total_products_discount_amount'] = $inputs['order_common_discount_amount'] + $inputs['order_discount_amount'];
        dd($inputs);
        $order = Order::updateOrCreate([
            'user_id' => $user->id,
            'payment_status' => 0
        ], $inputs);
        return redirect()->route('home.sales-proccess.payment');
    }
    
}
