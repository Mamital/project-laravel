<?php

namespace App\Http\Controllers\Customer\Market;

use Illuminate\Http\Request;
use App\Models\Market\Product;
use App\Http\Controllers\Controller;
use App\Models\Content\Comment;
use App\Models\User;
use App\Models\User\Compare;
use Illuminate\Support\Facades\Auth;
use Nagy\LaravelRating\Models\Rating;

class ProductController extends Controller
{
    public function index(Product $product)
    {
        $product = $product->with(['values' => function ($query) {
            $query->with('attribute');
        }])->where('id', $product->id)->first();
        
        $reletedProducts = Product::where('category_id', $product->category_id)->take(5)->get()->except($product->id);
        $amazingSale = $product->activeAmazingSales();

        $ratings = Rating::where(['rateable_type' => Product::class, 'rateable_id' => $product->id])->get();

        $comments = Comment::with(['answers' => function($query){
            $query->with('user', 'answers');
        }, 'user'])->where(['approved' => 1,'parent_id' => null, 'commentable_id' => $product->id, 'commentable_type' => Product::class])->get();
        
        return view('customer.market.product.product', compact(['product', 'reletedProducts', 'amazingSale', 'comments', 'ratings']));
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
    public function addCompare(Product $product)
    {
        
        if(Auth::check())
        {
            $user = Auth::user();

            if($user->compare->count() > 0)
            {
                $userCompare = $user->compare;
            }else{
                $userCompare = Compare::create(['user_id' => $user->id]);
            }

            if($userCompare->products->count() == 3 && !$userCompare->products->contains($product)){
                return response()->json(['status' => 4]);
                die;
            }
            
            $product->compares()->toggle($userCompare->id);

            if($product->compares->contains($userCompare->id))
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

    public function addRate(Product $product,Request $request)
    {
        $user = Auth::user();
        $user->rate($product, $request->rating);
        return back();
    }
}
