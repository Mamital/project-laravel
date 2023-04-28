<?php

namespace App\Http\Controllers\Customer\SalesProccess;

use App\Models\Market\Copan;
use App\Models\Market\Order;
use Illuminate\Http\Request;
use App\Models\Market\CartItem;
use App\Http\Controllers\Controller;
use App\Http\Services\Payment\PaymentService;
use App\Models\Market\CashPayment;
use App\Models\Market\OfflinePayment;
use App\Models\Market\OnlinePayment;
use App\Models\Market\OrderItem;
use App\Models\Market\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function payment()
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $order = Order::where([
            ['user_id', $user->id],
            ['order_status', 0]
        ])->first();
        return view('customer.sales-proccess.payment', compact('cartItems', 'order'));
    }

    public function copanDiscount(Request $request)
    {
        $request->validate([
            'copan' => 'required'
        ]);

        $user = auth()->user();

        $copan = Copan::where([
            ['code', $request->copan],
            ['start_date', '<', now()],
            ['end_date', '>', now()],
            ['status', 1]
        ])->first();

        if ($copan == null) {
            return redirect()->back()->with(['copan-error' => 'کد وارد شده نامعتبر است']);
        }

        if ($copan->type == 1) {
            $copan = Copan::where([
                ['code', $request->copan],
                ['start_date', '<', now()],
                ['end_date', '>', now()],
                ['status', 1],
                ['user_id', $user->id]
            ])->first();
        } else {
            return redirect()->back()->with(['copan-error' => 'کد وارد شده نامعتبر است']);
        }

        $order = Order::where([
            ['user_id', $user->id],
            ['order_status', 0],
            ['copan_id', null]
        ])->first();

        if ($order) {
            if ($copan->amount_type == 0) {
                $copanDiscountAmount = $order->order_final_amount * ($copan->amount / 100);

                if ($copanDiscountAmount >= $copan->discount_ceiling) {
                    $copanDiscountAmount = $copan->discount_ceiling;
                }
            } else {
                $copanDiscountAmount = $copan->amount;
            }


            $order->order_final_amount -= $copanDiscountAmount; //with discount
            $order->save;


            $totalDiscount = $order->order_total_products_discount_amount + $copanDiscountAmount;

            $order->update([
                'copan_id' => $copan->id,
                'order_total_products_discount_amount' => $totalDiscount,
                'order_copan_discount_amount' => $copanDiscountAmount
            ]);
            return redirect()->back()->with(['copan-success' => 'کد تخفیف شما با موفقیت اعمال شد']);
        } else {
            return redirect()->back()->with(['copan-error' => 'برای این سفارش، قبلا کد تخفیف اعمال شده است']);
        }
    }

    public function paymentSubmit(Request $request, PaymentService $paymentService)
    {
        $request->validate([
            'payment_type' => 'required',
        ]);

        $order = Order::where([
            'user_id' => Auth::user()->id,
            'order_status' => 0
        ])->first();
        $cash_receiver = null;
        $cartItems = CartItem::where('user_id', Auth::user()->id)->get();

        switch ($request->payment_type) {
            case '1':
                $targetModel = OnlinePayment::class;
                $type = 0;
                break;
            case '2':
                $targetModel = OfflinePayment::class;
                $type = 1;
                break;
            case '3':
                $targetModel = CashPayment::class;
                $type = 2;
                $cash_receiver = $request->cash_receiver ? $request->cash_receiver : null;
                break;

            default:
                return redirect()->back();
        }

        $paymented = $targetModel::create([
            'amount' => $order->order_final_amount,
            'user_id' => auth()->user()->id,
            'pay_date' => now(),
            'status' => 1,
            'cash_receiver' => $cash_receiver
        ]);

        if ($type == 0) {
            $result = $paymentService->zarinpal($order->order_final_amount, $paymented, $order);
        }

        $payment = Payment::create([
            'amount' => $order->order_final_amount,
            'user_id' => auth()->user()->id,
            'pay_date' => now(),
            'type' => $type,
            'status' => 1,
            'paymentable_id' => $paymented->id,
            'paymentable_type' => $targetModel
        ]);


        if ($type == 0) { //online
            if ($result['status']) {
                
                return redirect()->away('https://sandbox.zarinpal.com/pg/StartPay/' . $result['authority']);
            } else {
                return redirect()->route('home')->with('alert-error', $result['message']);
            }
        } else { //offline and cash
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product' => $cartItem->product,
                    'amazing_sale_id' => $cartItem->product->activeAmazingSales()->id ?? 0,
                    'amazing_sale_object' => $cartItem->product->activeAmazingSales() ?? null,
                    'amazing_sale_discount_amount' => $cartItem->cartItemProductDiscount(),
                    'number' => $cartItem->number,
                    'final_product_price' => $cartItem->cartItemProductDiscount(),
                    'final_total_price' => $cartItem->cartItemFinalPrice(),
                    'color_id' => $cartItem->color_id,
                    'guarantee_id' => $cartItem->guarantee_id

                ]);
                $cartItem->delete();
            }
        }
        $order->update(['order_status' => 1]);
        return redirect()->route('home')->with(['alert-success' => 'سفارش شما با موفقیت ثبت گردید']);
    }

    public function paymentCallback(Order $order, OnlinePayment $onlinePayment, PaymentService $paymentService)
    {
        $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
        $amount = $order->order_final_amount;
        $result = $paymentService->zarinpalVerify($amount, $onlinePayment);
        $refID = $result['ref_id'] != 0 ? $result['ref_id'] : '-';

        if ($result['success']) {

            $payment = Payment::where('paymentable_id', $onlinePayment->id)->update(['payment_status' => 1]);
            $order->update(['order_status' => 1, 'payment_status' => 1]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product' => $cartItem->product,
                    'amazing_sale_id' => $cartItem->product->activeAmazingSales()->id ?? 0,
                    'amazing_sale_object' => $cartItem->product->activeAmazingSales() ?? null,
                    'amazing_sale_discount_amount' => $cartItem->cartItemProductDiscount(),
                    'number' => $cartItem->number,
                    'final_product_price' => $cartItem->cartItemProductDiscount(),
                    'final_total_price' => $cartItem->cartItemFinalPrice(),
                    'color_id' => $cartItem->color_id,
                    'guarantee_id' => $cartItem->guarantee_id

                ]);
                $cartItem->delete();
            }

            return redirect()->route('home')->with('alert-success', $result['message'] . ' - ' . 'شناسه تراکنش : ' . $refID);
        } else {
            return redirect()->route('home')->with('alert-error', $result['message'] . ' - ' . 'شناسه تراکنش : ' . $refID);
        }
    }
}
