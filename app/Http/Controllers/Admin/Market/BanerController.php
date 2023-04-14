<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\BanerRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Market\Baner;
use Illuminate\Http\Request;

class BanerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $baners = Baner::all();
        return view('admin.market.baner.index', compact('baners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.market.baner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BanerRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'baners');
            $result = $imageService->save($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.market.baner.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }

        Baner::create($inputs);
        return redirect()->route('admin.market.baner.index')->with('swal-success', 'بنر جدید با موفقیت ایجاد شد');

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
    public function edit(Baner $baner)
    {
        return view('admin.market.baner.edit', compact('baner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BanerRequest $request, ImageService $imageService, Baner $baner)
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            if(!empty($baner->image))
            {
                $imageService->deleteImage($baner->image);
            }            
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'baners');
            $result = $imageService->save($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.market.baner.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }

        $baner->update($inputs);
        return redirect()->route('admin.market.baner.index')->with('swal-success', 'بنر جدید با موفقیت ایجاد شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Baner $baner)
    {
        $baner->delete();
        return redirect()->route('admin.market.baner.index')->with('swal-success', 'بنر جدید با موفقیت حذف شد');
    }
    public function status(Baner $baner)
    {

        $baner->status = $baner->status == 0 ? 1 : 0;
        $result = $baner->save();
        if ($result) {
            if ($baner->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
