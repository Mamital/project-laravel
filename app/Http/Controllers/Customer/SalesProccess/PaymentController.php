<?php

namespace App\Http\Controllers\Customer\SalesProccess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment()
    {
        return view('customer.sales-proccess.payment');
    }
}
