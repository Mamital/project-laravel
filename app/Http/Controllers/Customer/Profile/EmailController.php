<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Models\Otp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\Email\EmailService;

class EmailController extends Controller
{
    public function form()
    {
        return view('customer.profile.my-email');
    }
    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users,email|email'
        ]);

        $inputs = $request->all();
        $user = Auth::user();
        $email = $inputs['email'];

        $otpCode = rand(111111, 999999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'type' => 1,
            'login_id' => $email
        ];

        Otp::create($otpInputs);


        $details = [
            'title' => 'فعالسازی حساب کاربری',
            'body' => "کد فعالسازی شما : $otpCode"
        ];

        $emailService = new EmailService();
        $emailService->setDetails($details);
        $emailService->setTo($email);
        $emailService->setFrom('noreplay@example.com', 'example');
        $emailService->setsubject('احراز هویت');

        $messageService = new MessageService($emailService);
        $messageService->send();
        return redirect()->route('home.profile.my-email.confirm-form', $token);
    }

    public function confirmForm($token)
    {
        $otp = Otp::where('token', $token)->first();
        if (empty($otp)) {
            return redirect()->route('home.profile.my-email.index')->withErrors('email', 'آدرس معتبر نمیباشد');
        }
        $email = $otp->login_id;
        return view('customer.profile.my-email-confirm', compact(['token', 'otp', 'email']));
    }
    public function confirm(Request $request, $token)
    {
        $inputs = $request->all();
        $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString())->first();

        if (empty($otp)) {
            return redirect()->route('home.profile.my-email', $token)->withErrors(['email' => 'آدرس معتبر نمیباشد']);
        }

        if ($otp->otp_code !== $inputs['otp']) {
            return redirect()->route('home.profile.my-email.confirm-form', $token)->withErrors(['otp' => 'کد وارد شده نامعتبر میباشد']);
        }

        $otp->update(['used' => 1]);

        $user = $otp->user;
        $email = $otp->login_id;
        $user->update(['email_verified_at' => Carbon::now(), 'email' => $email]);

        return redirect()->route('home.profile.my-profile');
    }
}
