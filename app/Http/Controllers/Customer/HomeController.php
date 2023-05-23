<?php

namespace App\Http\Controllers\Customer;

use App\Models\Market\Baner;
use App\Models\Market\Brand;
use Illuminate\Http\Request;
use App\Models\Market\Product;
use App\Http\Controllers\Controller;
use App\Models\Market\ProductCategory;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {        
        $topBannerSliders = Baner::where('position', 0)->where('status', 1)->get();
        $topBannerUp = Baner::where('position', 1)->where('status', 1)->first();
        $topBannerBottom = Baner::where('position', 2)->where('status', 1)->first();
        $middleBanners = Baner::where('position', 3)->where('status', 1)->take(2)->get();
        $bottomBanner = Baner::where('position', 4)->where('status', 1)->first();
        $brands = Brand::all();
        $mostVisitedProducts = Product::latest()->where('status', 1)->take(5)->get();
        $offerProducts = Product::latest()->where('status', 1)->take(5)->get();

        return view('customer.home', compact(['topBannerSliders', 'topBannerUp', 'topBannerBottom', 'middleBanners', 'bottomBanner', 'brands', 'mostVisitedProducts', 'offerProducts']));
    }

    public function products(Request $request, ProductCategory $productCategory = null)
    {
        //brands

        $brands = Brand::where('status', 1)->get();
        $categories = ProductCategory::where('parent_id', null)->get();
        $productModel = null;
        if($productCategory){
            $productModel = $productCategory->products();            
        }
        else
        $productModel = new Product();

        switch ($request->sort) {
            case '1':
                $sort = 'created_at';
                $direction = 'ASC';
                break;
            case '2':
                $sort = 'price';
                $direction = 'DESC';
                break;
            case '3':
                $sort = 'price';
                $direction = 'ASC';
                break;
            case '4':
                $sort = 'view';
                $direction = 'DESC';
                break;
            case '5':
                $sort = 'sold_number';
                $direction = 'DESC';
                break;

            default:
                $sort = 'created_at';
                $direction = 'DESC';
                break;
        }
        if ($request->search) {
            $query = $productModel->where('name', 'LIKE', "%{$request->search}%")->orderBy($sort, $direction);
        } else {
            $query = $productModel->orderBy($sort, $direction);
        }

        $products = $request->max_price && $request->min_price ? $query->whereBetween('price', [$request->min_price, $request->max_price]) :
            $query->when(
                $request->max_price,
                function ($query) use ($request) {
                    $query->where('price', '<=', $request->max_price);
                }
            )->when(
                $request->min_price,
                function ($query) use ($request) {
                    $query->where('price', '>=', $request->min_price);
                }
            );

        $products = $products->when($request->brands, function () use ($request, $products) {
            $products->whereIn('brand_id', $request->brands);
        });
        $selected_brands = [];
        if ($request->brands) {
            $selected_brands_array = Brand::find($request->brands);
            foreach ($selected_brands_array as $brand) {
                array_push($selected_brands, $brand->persian_name);
            }
        }        
        $products = $products->paginate();
        $products->appends($request->query());
        return view('customer.market.product.products', compact('products', 'brands', 'selected_brands', 'categories', 'productCategory'));
    }
}

