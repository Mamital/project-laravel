<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Models\Otp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Models\User;

class PhoneNumberController extends Controller
{
    public function form()
    {
        return view('customer.profile.my-number');
    }
    public function update(Request $request)
    {

        $inputs = $request->all();
        $user = Auth::user();
        $mobile = $inputs['mobile'];


        if (preg_match('/^(\+98|98|0)9\d{9}$/', $mobile)) {
            $mobile = ltrim($mobile, '0');
            $mobile = substr($mobile, 0, 2) === '98' ? substr($mobile, 2) : $mobile;
            $mobile = str_replace('+98', '', $mobile);
            $valide = User::where('mobile', $mobile)->first();
            if($valide){
                return redirect()->route('home.profile.my-number.index')->withErrors(['mobile' => 'شماره موبایل قبلا ثبت شده است']);
            }
            $otpCode = rand(111111, 999999);
            $token = Str::random(60);

            $user->mobile = $mobile;

            $otpInputs = [
                'token' => $token,
                'user_id' => $user->id,
                'otp_code' => $otpCode,
                'type' => 0,
                'login_id' => $mobile
            ];

            Otp::create($otpInputs);
            //sms 

            $text = "مشترک عزیز 
            رمز موقت تایید : $otpCode";

            $smsService = new SmsService();
            $smsService->setFrom(Config::get('sms.otp_from'));
            $smsService->setTo(['0' . $mobile]);
            $smsService->setText($text);

            $messageService = new MessageService($smsService);
            $messageService->send();
        }else{
            return redirect()->route('home.profile.my-number.index')->withErrors(['mobile' => 'شماره موبایل معتبر نیست']);
        }

        return redirect()->route('home.profile.my-number.confirm-form', $token);
    }

    public function confirmForm($token)
    {   
        $otp = Otp::where('token', $token)->first();
        if (empty($otp)) {
            return redirect()->route('customer.profile.my-number')->withErrors('mobile', 'آدرس معتبر نمیباشد');
        }
        $mobile = $otp->login_id;
        return view('customer.profile.my-number-confirm', compact(['token', 'otp', 'mobile']));
    }
    public function confirm(Request $request, $token)
    {
        $inputs = $request->all();
        $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString())->first();

        if (empty($otp)) {
            return redirect()->route('home.profile.my-number', $token)->withErrors(['mobile' => 'آدرس معتبر نمیباشد']);
        }

        if ($otp->otp_code !== $inputs['otp']) {
            return redirect()->route('home.profile.my-number.confirm-form', $token)->withErrors(['otp' => 'کد وارد شده نامعتبر میباشد']);
        }

        $otp->update(['used' => 1]);

        $user = $otp->user;
        $mobile = $otp->login_id;
        $user->update(['mobile_verified_at' => Carbon::now(), 'mobile' => $mobile]);

        return redirect()->route('home.profile.my-profile');
    }
}
