<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Models\User\Address;
use Illuminate\Http\Request;
use App\Models\User\Province;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $provinces = Province::all();
        $addresses = Address::where('user_id', $user->id)->get();
        return view('customer.profile.my-address', compact('provinces', 'addresses'));
    }
}
