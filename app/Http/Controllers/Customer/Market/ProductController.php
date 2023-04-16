<?php

namespace App\Http\Controllers\Customer\Market;

use Illuminate\Http\Request;
use App\Models\Market\Product;
use App\Http\Controllers\Controller;
use App\Models\Content\Comment;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Product $product)
    {
        Auth::loginUsingId(6);
        $reletedProducts = Product::take(7)->get();
        $amazingSale = $product->activeAmazingSales();
        return view('customer.market.product.product', compact(['product', 'reletedProducts', 'amazingSale']));
    }
    public function addComment(Product $product, Request $request)
    {
        $inputs = $request->all();
        $inputs['body'] = str_replace(PHP_EOL, '</br>', $request->body);
        $inputs['author_id'] = Auth::user()->id;
        $inputs['commentable_id'] = $product->id;
        $inputs['commentable_type'] = Product::class;
        $comment = Comment::create($inputs);
        return back();

    }
    public function addFavorite(Product $product)
    {
        
        if(Auth::check())
        {
            $product->users()->toggle(Auth::user()->id);

            if($product->users->contains(Auth::user()->id))
            {
                return response()->json(['status' => 1]);
            }else{
                return response()->json(['status' => 2]);
            }
        }else
        {
            return response()->json(['status' => 3]);
        }
    }
}
