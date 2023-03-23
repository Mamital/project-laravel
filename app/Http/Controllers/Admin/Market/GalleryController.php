<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Services\Image\ImageService;
use App\Models\Market\Gallery;
use App\Models\Market\Product;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $images = Gallery::where('product_id', $product->id)->get();
        return view('admin.market.product.gallery.index', compact(['images', 'product']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('admin.market.product.gallery.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, ImageService $imageService)
    {
        $validation = $request->validate(
            [
                'image' => 'required|mimes:png,jpg,jpeg,gif',
            ]
        );
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-gallery');
            $result = $imageService->createIndexAndSave($request->file('image'));
            $inputs['image'] = $result;
        }
        if ($result === false) {
            return redirect()->route('admin.market.gallery.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
        }
        $inputs['product_id'] = $product->id;
        $gallery = Gallery::create($inputs);
        return redirect()->route('admin.market.gallery.index', $product->id)->with('swal-success', 'عکس جدید با موفقیت ثبت شد');
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
    public function destroy(Product $product, Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.market.gallery.index', $product->id)->with('swal-success', 'عکس جدید با موفقیت حذف شد');
    }

    public function status(Gallery $gallery)
    {
        $gallery->status = $gallery->status == 0 ? 1 : 0;
        $result = $gallery->save();
        if ($result) {
            if ($gallery->status == 1) {
                return response()->json(['status' => true, 'checked' => true]);
            } else {
                return response()->json(['status' => true, 'checked' => false]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
