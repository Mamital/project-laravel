<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\Market\Product;
use App\Models\Market\ProductColor;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $colors = ProductColor::where('product_id', $product->id)->get();
        return view('admin.market.product.color.index', compact(['colors', 'product']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('admin.market.product.color.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $validation = $request->validate([
            'price_increase' => 'required|numeric',
            'color_name' => 'required|min:2|max:1000|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'status' => 'required|numeric|in:0,1',
        ]);
        $inputs = $request->all();
        $inputs['product_id'] = $product->id;
        $result = ProductColor::create($inputs);
        return redirect()->route('admin.market.color.index', $product->id)->with('swal-success', 'رنگ مورد نظر با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductColor $productColor)
    {
        $productColor->delete();
        return redirect()->route('admin.market.color.index', $product->id)->with('swal-success', 'رنگ مورد نظر با موفقیت حذف شد');
    }

    public function status(ProductColor $productColor)
    {
        $productColor->status = $productColor->status == 0 ? 1 : 0;
        $result = $productColor->save();
        if ($result) {
            if ($productColor->status == 1) {
                return response()->json(['status' => true, 'checked' => true]);
            } else {
                return response()->json(['status' => true, 'checked' => false]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
