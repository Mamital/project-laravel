<?php

namespace App\Http\Controllers\Customer\SalesProccess;

use App\Http\Controllers\Controller;
use App\Models\Market\CartItem;
use App\Models\Market\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart()
    {
        $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
        $reletedProducts = Product::all();
        return view('customer.sales-proccess.cart', compact(['cartItems', 'reletedProducts']));
    }
    public function updateCart(Request $request)
    {
        if (Auth::check()) {
            $inputs = $request->all();
            $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
            foreach ($cartItems as $cartItem) {
                if (isset($inputs['number'][$cartItem->id])) {
                    $cartItem->update(['number' => $inputs['number'][$cartItem->id]]);
                }
            }
            return redirect()->route('home.sales-proccess.address-and-delivery');
        } else {
            return redirect()->route('auth.customer.login-register-form');
        }
    }
    public function addToCart(Product $product, Request $request)
    {
        if (Auth::check()) {
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
            $inputs['user_id'] = Auth::user()->id;
            CartItem::create($inputs);
            return back()->with('alert-section-success', 'محصول مورد نظر با موفقیت به سبد خرید اضافه شد');
        } else {
            return redirect()->route('auth.customer.login-register-form');
        }
    }
    public function removeFromCart(CartItem $cartItem)
    {
        if (Auth::user()->id === $cartItem->user_id) {
            $cartItem->delete();
        }
        return back();
    }
}
