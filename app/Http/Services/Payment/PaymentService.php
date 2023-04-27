<?php

namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Config;

class PaymentService
{
    public function zarinpal($amount, $onlinePayment, $order)
    {
        // dd($onlinePayment);
        $data = array(
            "MerchantID" => Config::get('payment.zarinpal_api_key'),
            "Amount" => $amount,
            "CallbackURL" => route('home.sales-proccess.payment-callback', [$order->id, $onlinePayment->id]),
            "Description" => "بعد تراکنش سفارش شما ثبت میگردد",
            "Metadata" => ["email" => "info@email.com", "mobile" => "09121234567"],
        );

        $jsonData = json_encode($data);
        $responce =
            curl_init('https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentRequest.json');
        curl_setopt($responce, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($responce, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($responce, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($responce, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($responce, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($responce);
        $err = curl_error($responce);
        $result = json_decode($result, true, JSON_PRETTY_PRINT);
        curl_close($responce);

        $status = $result['Status'];
        $message = $this->resultSatus($status);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            if ($status == 100) {
                $onlinePayment->update(['bank_first_response' => $result]);
                $authority = $result['Authority'];
                return ['authority' => $authority, 'status' => true, 'message' => $message];
            } else {
                return ['status' => false, 'message' => $message];
            }
        }
    }

    public function zarinpalVerify($amount, $onlinePayment)
    {
        $authority = $_GET['Authority'];
        $data = ['MerchantID' => Config::get('payment.zarinpal_api_key'), 'Authority' => $authority, 'Amount' => (int)$amount];
        $jsonData = json_encode($data);
        $ch = curl_init('https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentVerification.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true, JSON_PRETTY_PRINT);
        $message = $this->resultSatus($result['Status']);
        $refId = $result['RefID'] ;
        $onlinePayment->update(['bank_second_response' => $result, 'transaction_id' => $refId, 'gateway' => 'زرین پال']);
        if ($result['Status'] == 100) {
            return ['success' => true, 'message' => $message, 'ref_id' => $refId];
        } else {
            return ['success' => false, 'message' => $message, 'ref_id' => $refId];
        }
    }


    public function resultSatus($status)
    {
        $error = array(
            "-1"     => "اطلاعات ارسال شده ناقص است.",
            "-2"     => "IP و يا مرچنت كد پذيرنده صحيح نيست",
            "-3"     => "با توجه به محدوديت هاي شاپرك امكان پرداخت با رقم درخواست شده ميسر نمي باشد",
            "-4"     => "سطح تاييد پذيرنده پايين تر از سطح نقره اي است.",
            "-11"     => "درخواست مورد نظر يافت نشد.",
            "-12"     => "امكان ويرايش درخواست ميسر نمي باشد.",
            "-21"     => "هيچ نوع عمليات مالي براي اين تراكنش يافت نشد",
            "-22"     => "تراكنش نا موفق ميباشد",
            "-33"     => "رقم تراكنش با رقم پرداخت شده مطابقت ندارد",
            "-34"     => "سقف تقسيم تراكنش از لحاظ تعداد يا رقم عبور نموده است",
            "-40"     => "اجازه دسترسي به متد مربوطه وجود ندارد.",
            "-41"     => "اطلاعات ارسال شده مربوط غيرمعتبر ميباشد.",
            "-42"     => "مدت زمان معتبر طول عمر شناسه پرداخت بايد بين 30 دقيه تا 45 روز مي باشد.",
            "-54"     => "درخواست مورد نظر آرشيو شده است",
            "100"     => "عمليات با موفقيت انجام گرديده است.",
            "101"     => "تراکنش قبلا با موفقیت انجام شده است",
        );

        if (array_key_exists($status, $error)) {
            return $error[$status];
        } else {
            return 'خطای نا مشخص در سیستم رخ داد';
        }
    }
}
