<?php

namespace App\Http\Controllers\Admin\Market;

use Illuminate\Http\Request;
use App\Models\Market\Product;
use App\Models\Market\Property;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Market\CategoryValue;
use App\Http\Requests\Admin\Market\CategoryValueRequest;

class CategoryValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $properties = $product->category->properties;
        $values = $product->values;        
        return view('admin.market.product.property', compact(['properties', 'product']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Property $property)
    {
        $products = Product::where('category_id', $property->category->id)->get();
        return view('admin.market.property.value.create', compact(['property', 'products']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $inputs = $request->all();
        DB::transaction(function () use ($request, $product) {
            $metas = array_combine($request->meta_key, $request->meta_value);
            foreach ($metas as $key => $value) {
                if ($value) {
                    CategoryValue::updateOrCreate([
                        'type' => 0,
                        'value' => $value,
                        'category_attribute_id' => $key,
                        'product_id' => $product->id,
                    ]);
                }
            }
        });

        return redirect()->route('admin.market.product.index')->with('swal-success', 'مقادیر با موفقیت ثبت شدند');
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
    public function edit(Property $property ,CategoryValue $categoryValue)
    {
        $products = Product::where('category_id', $property->category->id)->get();
        return view('admin.market.property.value.edit', compact(['categoryValue', 'property', 'products']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryValueRequest $request,Property $property, CategoryValue $categoryValue )
    {
        $inputs = $request->all();
        $inputs['value'] = json_encode(['value' => $request->value, 'price_increase' => $request->price_increase]);
        $inputs['category_attribute_id'] = $property->id;
        $result = $categoryValue->update($inputs);
        return redirect()->route('admin.market.value.index', $property->id)->with('swal-success', 'مقدار جدید با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property ,CategoryValue $categoryValue)
    {
        $categoryValue->delete();
        return redirect()->route('admin.market.value.index', $property->id)->with('swal-success', 'مقدار جدید با موفقیت حذف شد');
    }
}
