<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\Market\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return view('admin.market.payment.index', compact('payments'));
    }
    public function offline()
    {
        $payments = Payment::where('type', 1)->get();
        return view('admin.market.payment.index', compact('payments'));
    }
    public function online()
    {
        $payments = Payment::where('type', 0)->get();
        return view('admin.market.payment.index', compact('payments'));
    }
    public function attendance()
    {
        $payments = Payment::where('type', 2)->get();
        return view('admin.market.payment.index', compact('payments'));
    }
    public function confirm()
    {
        return view('admin.market.payment.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        return view('admin.market.payment.show', compact('payment'));
    }
    public function cancel(Payment $payment)
    {
        $payment->payment_status = 2;
        $result = $payment->save();
        return redirect()->back()->with('swal-success', 'تغییر شما با موفقیت انجام شد');
    }
    public function return(Payment $payment)
    {
        $payment->payment_status = 3;
        $result = $payment->save();
        return redirect()->back()->with('swal-success', 'تغییر شما با موفقیت انجام شد');
    }
}
