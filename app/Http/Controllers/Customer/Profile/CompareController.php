<?php

namespace App\Http\Controllers\Customer\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Market\Product;
use App\Models\Market\Property;
use Illuminate\Support\Facades\Auth;

class CompareController extends Controller
{
    public function compare(Request $request)
    {
        $user = Auth::user();
        $products = $user->compare->products;
        $categories = collect();
        foreach($products as $product)
        {
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
