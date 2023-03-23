@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش مقدار جدید</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">فرم کالا</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش مقدار جدید</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش مقدار جدید
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.market.value.index', $property->id) }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.market.value.update', ['property' => $property->id, 'categoryValue' => $categoryValue->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <section class="row">

                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="value">مقدار</label>
                                    <input type="text" class="form-control form-control-sm" name="value" id="value"
                                        value="{{ old('value', json_decode($categoryValue->value)->value) }}">
                                </div>
                                @error('value')
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
                                    <input type="text" class="form-control form-control-sm" name="price_increase"
                                        id="price_increase" value="{{ old('price_increase', json_decode($categoryValue->value)->price_increase) }}">
                                </div>
                                @error('price_increase')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">انتخاب محصول</label>
                                    <select name="product_id" class="form-control form-control-sm">
                                        <option value="">محصول را انتخاب کنید</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                @if (old('product_id', $categoryValue->product_id) == $product->id) selected @endif>{{ $product->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('product_id')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="type">نوع</label>
                                    <select name="type" id="" class="form-control form-control-sm"
                                        id="type">
                                        <option value="0" @if (old('type', $categoryValue->type) == 0) selected @endif>ساده
                                        </option>
                                        <option value="1" @if (old('type', $categoryValue->type) == 1) selected @endif>انتخابی
                                        </option>
                                    </select>
                                </div>
                                @error('type')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <button class="btn btn-primary btn-sm">ثبت</button>
                            </section>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>
@endsection
