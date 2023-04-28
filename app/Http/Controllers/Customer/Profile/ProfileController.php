<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Profile\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('customer.profile.my-profile', compact('user'));
    }
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $user->update($request->all());
        return redirect()->route('home.profile.my-profile');
    }
}
