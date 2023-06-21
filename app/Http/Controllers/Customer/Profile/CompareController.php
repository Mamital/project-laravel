<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Models\User\Compare;
use Illuminate\Http\Request;
use App\Models\Market\Product;
use App\Models\Market\Property;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompareController extends Controller
{
    public function compare(Request $request)
    {
        $user = Auth::user();

        if ($user->compare == null) {
            $userCompare = Compare::create(['user_id' => $user->id]);
            $products = $userCompare->products;
        } else {
            $products = $user->compare->products;
        }
        $categories = collect();
        foreach ($products as $product) {
            $categories->push($product->category_id);
        }
        $categories = $categories->unique();

        $properties = Property::whereIn('category_id', $categories)->with('values')->get();
        $properties = $properties->filter();

        return view('customer.market.product.compare', compact('products', 'properties'));
    }

    public function remove(Product $product)
    {
        $user = Auth::user();
        $compare = $user->compare->products()->detach($product->id);
        return back();
    }
}
