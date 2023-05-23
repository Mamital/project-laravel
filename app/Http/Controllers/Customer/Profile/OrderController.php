<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Models\Market\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orders()
    {
        $user = Auth::user();
        if (isset(request()->type)) {
            $orders = Order::where(['user_id' => $user->id, 'order_status' => request()->type])->orderBy('created_at')->get();
        } else {
            $orders = Order::where('user_id', $user->id)->orderBy('created_at')->get();
        }


        return view('customer.profile.my-order', compact('orders'));
    }
}
