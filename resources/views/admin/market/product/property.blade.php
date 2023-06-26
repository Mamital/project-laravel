@extends('admin.layouts.master')

@section('head-tag')
    <title>ایجاد کالا</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">کالا </a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد کالا</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد کالا
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.market.product.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.market.value.store', $product) }}" method="POST" id="form">
                        @csrf
                        <section class="row">

                            @foreach ($properties as $property)
                                <section class="col-6 col-md-3">
                                    <div class="form-group">
                                        <input type='hidden' class="form-control form-control-sm"
                                            name="meta_key[]" value="{{$property->id}}">
                                        <input type="text" class="form-control form-control-sm" value="{{$property->name}}" disabled>
                                    </div>
                                </section>

                                <section class="col-6 col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" placeholder="مقدار ..."
                                            name="meta_value[]">
                                    </div>
                                </section>
                            @endforeach

                        </section>

                </section>

                <section class="col-12">
                    <button class="btn btn-primary btn-sm">ثبت</button>
                </section>
            </section>
            </form>
        </section>

    </section>
@endsection
