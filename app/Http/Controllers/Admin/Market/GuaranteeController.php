<?php

namespace App\Http\Controllers\Admin\Market;

use Illuminate\Http\Request;
use App\Models\Market\Product;
use App\Models\Market\Guarantee;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\GuaranteeRequest;

class GuaranteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $guarantees = Guarantee::all();
        return view('admin.market.product.guarantee.index', compact(['guarantees', 'product']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('admin.market.product.guarantee.create', compact('product'));
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
            'name' => 'required|min:2|max:1000|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'status' => 'required|numeric|in:0,1',
        ]);
        $inputs = $request->all();
        $inputs['product_id'] = $product->id;
        $result = Guarantee::create($inputs);
        return redirect()->route('admin.market.guarantee.index', $product->id)->with('swal-success', 'رنگ مورد نظر با موفقیت ثبت شد');
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
    public function destroy(Guarantee $guarantee, Product $product)
    {
        $guarantee->delete();
        return redirect()->route('admin.market.guarantee.index', $product->id)->with('swal-success', 'رنگ مورد نظر با موفقیت حذف شد');
    }

    public function status(Guarantee $guarantee)
    {
        $guarantee->status = $guarantee->status == 0 ? 1 : 0;
        $result = $guarantee->save();
        if ($result) {
            if ($guarantee->status == 1) {
                return response()->json(['status' => true, 'checked' => true]);
            } else {
                return response()->json(['status' => true, 'checked' => false]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
