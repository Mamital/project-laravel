<?php

namespace App\Http\Controllers\Customer\Profile;

use Illuminate\Http\Request;
use App\Models\Market\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function favorites()
    {
        $products = Auth::user()->products;
        return view('customer.profile.my-favorite', compact('products'));
    }
    public function deleteFavorite(Product $product)
    {
        $user = Auth::user();
        $user->products()->detach($product->id);
        return redirect()->back()->with('alert-success', 'محصول مورد نظر با موفقیت از علاقه مندی ها حذف شد');
    }
}
