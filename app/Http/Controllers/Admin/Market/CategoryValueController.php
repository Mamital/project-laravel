<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\CategoryValueRequest;
use App\Models\Market\CategoryValue;
use App\Models\Market\Product;
use App\Models\Market\Property;
use Illuminate\Http\Request;

class CategoryValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Property $property)
    {
        $values = CategoryValue::where('category_attribute_id', $property->id)->get();
        return view('admin.market.property.value.index', compact(['values', 'property']));
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
    public function store(CategoryValueRequest $request, Property $property)
    {
        $inputs = $request->all();
        $inputs['value'] = json_encode(['value' => $request->value , 'price_increase' => $request->price_increase]);
        $inputs['category_attribute_id'] = $property->id;
        $result = CategoryValue::create($inputs);
        return redirect()->route('admin.market.value.index', $property->id)->with('swal-success', 'مقدار جدید با موفقیت ثبت شد');
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
