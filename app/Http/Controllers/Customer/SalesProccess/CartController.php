<?php

namespace App\Http\Controllers\Customer\SalesProccess;

use App\Http\Controllers\Controller;
use App\Models\Market\CartItem;
use App\Models\Market\CommonDiscount;
use App\Models\Market\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart()
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $reletedProducts = Product::all();        
        if(empty($cartItems->first()))
        {
            return redirect()->route('home')->with('alert-info' , 'سبد خرید شما خالی میباشد');
        }
        return view('customer.sales-proccess.cart', compact(['cartItems', 'reletedProducts']));
    }
    public function updateCart(Request $request)
    {
        $user = Auth::user();
        if ($user->first_name && $user->last_name && $user->mobile){
            if ($user->first_name && $user->last_name && $user->mobile)
            $inputs = $request->all();
            $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
            foreach ($cartItems as $cartItem) {
                if (isset($inputs['number'][$cartItem->id])) {
                    $cartItem->update(['number' => $inputs['number'][$cartItem->id]]);
                }
            }
            return redirect()->route('home.sales-proccess.address-and-delivery');
        } else {
            return redirect()->route('home.profile.my-profile')->with('alert-info', 'لطفا نام، نام خانوادگی و شماره موبایل خود را تکمیل کنید');
        }
    }
    public function addToCart(Product $product, Request $request)
    {
            $request->validate([
                'color' => 'nullable|exists:product_colors,id',
                'guarantee' => 'nullable|exists:guarantees,id',
                'number' => 'required|min:1|max:5',
            ]);

            //for update

            $cartItems = CartItem::where('product_id', $product->id)->where('user_id', Auth::user()->id)->get();
            if (empty($request->color)) {
                $request->color = null;
            }
            if (empty($request->guarantee)) {
                $request->guarantee = null;
            }            

            foreach ($cartItems as $cartItem) {
                if ($cartItem->color_id == $request->color && $cartItem->guarantee_id == $request->guarantee) {
                    if ($cartItem->number != $request->number) {
                        $cartItem->update(['number' => $request->number]);
                    }
                    return back();
                }
            }

            //for add

            $inputs = [];
            $inputs['color_id'] = $request->color;
            $inputs['guarantee_id'] = $request->guarantee;
            $inputs['product_id'] = $product->id;
            $inputs['number'] = $request->number;
            $inputs['user_id'] = Auth::user()->id;
            CartItem::create($inputs);
            return back()->with('alert-success', 'محصول مورد نظر با موفقیت به سبد خرید اضافه شد');
    }
    public function removeFromCart(CartItem $cartItem)
    {
        if (Auth::user()->id === $cartItem->user_id) {
            $cartItem->delete();
        }
        return back();
    }
}
