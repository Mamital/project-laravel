<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\CategoryAttributeRequest;
use App\Models\Market\CategoryAttribute;
use App\Models\Market\ProductCategory;
use App\Models\Market\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function category()
    {
        $categories = ProductCategory::whereNotNull('parent_id')->get();
        return view('admin.market.property.category', compact('categories'));
    }
    public function index(ProductCategory $productCategory)
    {
        $properties = $productCategory->properties;
        return view('admin.market.property.index', compact('properties', 'productCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ProductCategory $productCategory)
    {
        return view('admin.market.property.create', compact('productCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryAttributeRequest $request, ProductCategory $productCategory)
    {
        $inputs = $request->all();
        $result = Property::create([
            'name' => $inputs['name'],
            'unit' => $inputs['unit'],
            'category_id' => $productCategory->id
        ]);
        return redirect()->route('admin.market.property.index', $productCategory)->with('swal-success', 'فرم جدید با موفقیت ثبت شد');
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
    public function edit(ProductCategory $productCategory, Property $property)
    {
        return view('admin.market.property.edit', compact(['property', 'productCategory']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryAttributeRequest $request, ProductCategory $productCategory, Property $property)
    {
        $inputs = $request->all();
        $result = $property->update([
            'name' => $inputs['name'],
            'unit' => $inputs['unit'],
            'category_id' => $productCategory->id
        ]);
        return redirect()->route('admin.market.property.index', $productCategory)->with('swal-success', 'فرم جدید با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory, Property $property)
    {
        $property->delete();
        return redirect()->route('admin.market.property.index', $productCategory)->with('swal-success', 'فرم جدید با موفقیت حذف شد');
    }
}
