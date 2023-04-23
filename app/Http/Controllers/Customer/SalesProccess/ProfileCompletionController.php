<?php

namespace App\Http\Controllers\Customer\SalesProccess;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\SalesProccess\ProfileCompletionRequest;
use App\Models\Market\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileCompletionController extends Controller
{
    public function profileCompletion()
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
        return view('customer.sales-proccess.profile-completion', compact('cartItems', 'user'));
    }
    public function update(ProfileCompletionRequest $request)
    {
        $user = Auth::user();
        $inputs = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ];

        if (isset($request->national_code) && empty($user->national_code)) {
            $national_code = convertArabicToEnglish($request->national_code);
            $national_code = convertPersianToEnglish($national_code);

            $inputs['national_code'] = $national_code;
        }

        if (isset($request->mobile) && empty($user->mobile))
        {
            $mobile = convertArabicToEnglish($request->mobile);
            $mobile = convertPersianToEnglish($mobile);

            if (preg_match('/^(\+98|98|0)9\d{9}$/', $request->mobile))
            {
                $type = 0; //0 => mobile

                //all mobile numbers in one format (9**********)
                $mobile = ltrim($mobile, '0');
                $mobile = substr($mobile, 0, 2) == '98' ? substr($mobile, 2) : $mobile;
                $mobile = str_replace('+98', '', $mobile);

                $inputs['mobile'] = $mobile;
            } else {
                $errorText = 'فرمت شماره موبایل معتبر نیست';
                return back()->withErrors(['mobile' => $errorText]);
            }

        }
        if (isset($request->email) && empty($user->email)) {
            $email = convertArabicToEnglish($request->email);
            $email = convertPersianToEnglish($email);

            $inputs['email'] = $email;
        }

        $inputs = array_filter($inputs);

        if (!empty($inputs)) {
            $user->update($inputs);
        }
        return redirect()->route('home.sales-proccess.address-and-delivery');
    }
}
