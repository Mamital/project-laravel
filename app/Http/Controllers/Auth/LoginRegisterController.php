<?php

namespace App\Http\Controllers\Auth;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Http\Requests\Auth\LoginRegisterRequest;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Email\Services\Email\EmailService as EmailEmailService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginRegisterController extends Controller
{
    public function loginRegisterForm()
    {
        return view('customer.auth.login-register');
    }

    public function loginRegister(LoginRegisterRequest $request)
    {
        $inputs = $request->all();

        //check id is email or not
        if(filter_var($inputs['id'] , FILTER_VALIDATE_EMAIL))
        {
            $type = 1 ; // 1 => email
            $user = User::where('email', $inputs['id'])->first();
            if (empty($user)) {
                $newUser['email'] = $inputs['id'];
            }
        }
        elseif(preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['id']))
        {
            $type = 0 ; // 0 => mobile

            // all mobile numbers are in on format 9** *** ***
            $inputs['id'] = ltrim($inputs['id'], '0');
            $inputs['id'] = substr($inputs['id'], 0 , 2) === '98' ? substr($inputs['id'], 2) : $inputs['id'] ;
            $inputs['id'] = str_replace('+98', '', $inputs['id']);

            $user = User::where('mobile', $inputs['id'])->first();
            if (empty($user)) {
                $newUser['mobile'] = $inputs['id'];
            }

        } else {
            $errorText = 'شناسه ورودی شما نه شماره موبایل است نه ایمیل';
            return redirect()->route('auth.customer.login-register-form')->withErrors(['id' => $errorText]);
        }

        if(empty($user))
        {
            $newUser['password'] = '98355154' ;
            $newUser['activation'] = 1 ;
            $user = User::create($newUser);
        }

        //create otp code

        $otpCode = rand(111111, 999999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'type' => $type,
            'login_id' => $inputs['id']
        ];

        Otp::create($otpInputs);

        if($type == 0)
        {
            //sms 

            $text = "مشترک عزیز 
            رمز موقت ورود : $otpCode";
            
            $smsService = new SmsService();
            $smsService->setFrom(Config::get('sms.otp_from'));
            $smsService->setTo(['0' . $user->mobile]);
            $smsService->setText($text);

            $messageService = new MessageService($smsService);
            
        }elseif($type == 1)
        {
            $details = [
                'title' => 'فعالسازی حساب کاربری',
                'body' => "کد فعالسازی شما : $otpCode" 
            ];
            $emailService = new EmailService();
            $emailService->setDetails($details);
            $emailService->setTo($user->email);
            $emailService->setFrom('noreplay@example.com', 'example');
            $emailService->setsubject('احراز هویت');

            $messageService =new MessageService($emailService);
        }

        $messageService->send();

        return redirect()->route('auth.customer.login-confirm-form', $token);
    }

    public function logiConfirmForm($token)
    {
        $otp = Otp::where('token', $token)->first();
        if(empty($otp)){
            return redirect()->route('auth.customer.login-register-form')->withErrors('id', 'آدرس معتبر نمیباشد');
        }
        return view('customer.auth.login-confirm', compact(['token', 'otp']));
    }

    public function loginConfirm($token, LoginRegisterRequest $request)
    {
        $inputs = $request->all();
        $otp = Otp::where('token' , $token)->where('used', 0)->where('created_at' , '>=' , Carbon::now()->subMinute(5)->toDateTimeString())->first();

        if(empty($otp))
        {
            return redirect()->route('auth.customer.login-register-form', $token)->withErrors(['id' => 'آدرس معتبر نمیباشد']);
        }

        if($otp->otp_code !== $inputs['otp'])
        {
            return redirect()->route('auth.customer.login-confirm-form', $token)->withErrors(['otp' => 'کد وارد شده نامعتبر میباشد']);
        }
        
        $otp->update(['used' => 1]);
        
        $user = $otp->user;

        if($otp->type == 0 && $user->mobile_verified_at == null)
        {
            $user->update(['mobile_verified_at'=> Carbon::now()]);
        }
        elseif($otp->type == 1 && $user->email_verified_at == null)
        {
            $user->update(['email_verified_at'=> Carbon::now()]);
        }

        Auth::login($user);
        return redirect()->route('home');
    }

    public function loginResendConfirm($token)
    {
        $otp = Otp::where('token', $token)->where('created_at', '<=', Carbon::now()->subMinutes(5)->toDateTimeString())->first();
        if(empty($otp))
        {
            return redirect()->route('auth.customer.login-register-form')->withErrors('id', 'آدرس معتبر نمیباشد');
        }
        $user = $otp->user()->first();
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'type' => $otp->type,
            'login_id' => $otp->login_id
        ];

        Otp::create($otpInputs);

        if ($otp->type == 0) {
            //sms 

            $text = "مشترک عزیز 
            رمز موقت ورود : $otpCode";

            $smsService = new SmsService();
            $smsService->setFrom(Config::get('sms.otp_from'));
            $smsService->setTo(['0' . $user->mobile]);
            $smsService->setText($text);

            $messageService = new MessageService($smsService);
        } elseif ($otp->type == 1) {
            $details = [
                'title' => 'فعالسازی حساب کاربری',
                'body' => "کد فعالسازی شما : $otpCode"
            ];
            $emailService = new EmailService();
            $emailService->setDetails($details);
            $emailService->setTo($user->email);
            $emailService->setFrom('noreplay@example.com', 'example');
            $emailService->setsubject('احراز هویت');

            $messageService = new MessageService($emailService);
        }

        $messageService->send();

        return redirect()->route('auth.customer.login-confirm-form', $token);

    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
