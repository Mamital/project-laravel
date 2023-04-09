<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Market\Baner;
use App\Models\Market\Brand;
use App\Models\Market\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $topBannerSliders = Baner::where('position', 0)->where('status', 1)->get();
        $topBannerUp = Baner::where('position', 1)->where('status', 1)->first();
        $topBannerBottom = Baner::where('position', 2)->where('status', 1)->first();
        $middleBanner = Baner::where('position', 3)->where('status', 1)->take(2)->get();
        $bottomBanner = Baner::where('position', 4)->where('status', 1)->first();
        $brands = Brand::all();
        $mostViwedProducts = Product::latest()->where('status', 1)->take(5)->get();
        $offerProducts = Product::latest()->where('status', 1)->take(5)->get();

        return view('customer.home', compact(['topBannerSliders', 'topBannerUp', 'topBannerBottom', 'middleBanner', 'bottomBanner', 'brands', 'mostViwedProducts', 'offerProducts']));
    }
}
