@extends('admin.layouts.master')

@section('head-tag')
<title>ایجاد رنگ جدید</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">بخش فروش</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">دسته بندی</a></li>
      <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد رنگ جدید</li>
    </ol>
  </nav>


  <section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                  ایجاد رنگ جدید
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.market.color.index', $product->id) }}" class="btn btn-info btn-sm">بازگشت</a>
            </section>

            <section>
                <form action="{{ route('admin.market.color.store', $product->id) }}" method="POST">
                    @csrf
                    <section class="row">

                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="color_name">نام رنگ</label>
                                <input type="text" class="form-control form-control-sm" name="color_name" id="color_name" value="{{ old('color_name') }}">
                            </div>
                            @error('color_name')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="color">رنگ</label>
                                <input type="color" name="color" value="{{ old('color') }}" class="form-control form-control-sm form-control-color">
                            </div>
                            @error('color')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="price_increase">قیمت افزایش</label>
                                <input type="text" class="form-control form-control-sm" name="price_increase" id="price_increase" value="{{ old('price_increase') }}">
                            </div>
                            @error('price_increase')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="status">وضعیت</label>
                                <select name="status" id="" class="form-control form-control-sm" id="status">
                                    <option value="0" @if(old('status') == 0) selected @endif>غیرفعال</option>
                                    <option value="1" @if(old('status') == 1) selected @endif>فعال</option>
                                </select>
                            </div>
                            @error('status')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        </section>

                        <section class="col-12 my-3">
                            <button class="btn btn-primary btn-sm">ثبت</button>
                        </section>
                    </section>
                </form>
            </section>

        </section>
    </section>
</section>

@endsection
@section('script')
<script>
    $(function(){
        $("#btn-copy").on('click', function(){
          var ele = $(this).parent().prev().clone(true);
          $(this).before(ele);
        })
      })
</script>

@endsection