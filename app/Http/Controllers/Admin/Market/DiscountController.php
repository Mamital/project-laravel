<?php

namespace App\Http\Controllers\Admin\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\AmazingSaleRequest;
use App\Models\Market\CommenDiscount;
use App\Models\Market\CommonDiscount;
use App\Http\Requests\Admin\Market\CommenDiscountRequest;
use App\Http\Requests\Admin\Market\CommonDiscountRequest;
use App\Http\Requests\Admin\Market\CopanRequest;
use App\Models\Market\AmazingSale;
use App\Models\Market\Copan;
use App\Models\Market\Product;
use App\Models\User;

class DiscountController extends Controller
{

    //copan


    public function copan()
    {
        $copans = Copan::all();
        return view('admin.market.discount.copan', compact('copans'));
    }
    public function copanCreate()
    {
        $users = User::all();
        return view('admin.market.discount.copan-create', compact('users'));
    }
    public function copanEdit(Copan $copan)
    {
        $users = User::all();
        return view('admin.market.discount.copan-edit', compact(['users', 'copan']));
    }
    public function copanStore(CopanRequest $request)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        $realTimestampStart = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        if($inputs['type'] == 0)
        {
            $inputs['user_id'] = null;
        }
        Copan::create($inputs);
        return redirect()->route('admin.market.discount.copan')->with('swal-success', 'تخفیف عمومی  جدید شما با موفقیت ثبت شد');
    }
    public function copanUpdate(CopanRequest $request, Copan $copan)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        $realTimestampStart = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        if($inputs['type'] == 0)
        {
            $inputs['user_id'] = null;
        }
        // dd($inputs);
        $copan->update($inputs);
        return redirect()->route('admin.market.discount.copan')->with('swal-success', 'تخفیف عمومی  جدید شما با موفقیت ویرایش شد');
    }

    public function copanDestroy(Copan $copan)
    {
        $copan->delete();
        return redirect()->route('admin.market.discount.copan')->with('swal-success', 'تخفیف عمومی  جدید شما با موفقیت حذف شد');
    }


    //common discount



    public function commonDiscount()
    {
        $discounts = CommonDiscount::all();
        return view('admin.market.discount.common',compact('discounts'));
    }

    public function commonDiscountCreate()
    {
        return view('admin.market.discount.common-create');
    }

    public function commonDiscountStore(CommonDiscountRequest $request)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        $realTimestampStart = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        CommonDiscount::create($inputs);
        return redirect()->route('admin.market.discount.commonDiscount')->with('swal-success', 'تخفیف عمومی  جدید شما با موفقیت ثبت شد');
    }

    public function commonDiscountEdit(CommonDiscount $commonDiscount)
    {
        return view('admin.market.discount.common-edit', compact('commonDiscount'));
    }

    public function commonDiscountUpdate(CommonDiscountRequest $request, CommonDiscount $commonDiscount)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);

        // dd($inputs);

        $commonDiscount->update($inputs);
        return redirect()->route('admin.market.discount.commonDiscount')->with('swal-success', 'تخفیف عمومی  جدید شما با موفقیت ویرایش شد');
    }

    public function commonDiscountDestroy(CommonDiscount $commonDiscount)
    {
        $commonDiscount->delete();
        return redirect()->route('admin.market.discount.commonDiscount')->with('swal-success', 'تخفیف عمومی  جدید شما با موفقیت حذف شد');
    }


    //amazing sale


    public function amazingSale()
    {
        $discounts = AmazingSale::all();
        return view('admin.market.discount.amazing',compact('discounts'));
    }
    public function amazingSaleCreate()
    {
        $products = Product::all();
        return view('admin.market.discount.amazing-create',compact('products'));
    }
    public function amazingSaleStore(AmazingSaleRequest $request)
    {
        $inputs = $request->all();
        

        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        $realTimestampStart = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        AmazingSale::create($inputs);
        return redirect()->route('admin.market.discount.amazingSale')->with('swal-success', 'تخفیف شگفت انگیز جدید با موفقیت ثبت شد');
    }
    public function amazingSaleEdit(AmazingSale $amazingSale)
    {
        $products = Product::all();
        return view('admin.market.discount.amazing-edit', compact(['amazingSale', 'products']));
    }
    public function amazingSaleUpdate(AmazingSaleRequest $request, AmazingSale $amazingSale)
    {
        $inputs = $request->all();
        

        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        $realTimestampStart = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        $amazingSale->update($inputs);
        return redirect()->route('admin.market.discount.amazingSale')->with('swal-success', 'تخفیف شگفت انگیز جدید با موفقیت ویرایش شد');
    }
    public function amazingSaleDestroy(AmazingSale $amazingSale)
    {
        $amazingSale->delete();
        return redirect()->route('admin.market.discount.amazingSale')->with('swal-success', 'تخفیف شگفت انگیز جدید با موفقیت حذف شد');
    }
}
