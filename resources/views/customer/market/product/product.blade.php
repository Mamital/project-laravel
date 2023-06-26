@extends('customer.layouts.master-one-col')
@section('head-tag')
    <style>
        @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);

        /* Styling h1 and links
                                        ––––––––––––––––––––––––––––––––– */
        .starrating>input {
            display: none;
        }

        .fa-star {
            color: #ffca08
        }

        /* Remove radio buttons */

        .starrating>label:before {
            content: "\f005";
            /* Star */
            margin: 2px;
            font-size: 2em;
            font-family: FontAwesome;
            display: inline-block;
        }

        .starrating>label {
            color: #cfcfcf;
            /* Start color when not clicked */
        }

        .starrating>input:checked~label {
            color: #ffca08;
        }

        /* Set yellow color when star checked */

        .starrating>input:hover~label {
            color: #ffca08;
        }

        /* Three column layout */
        .side {
            float: left;
            width: 15%;
            margin-top: 10px;
        }

        #rating-chart {
            width: 50%;
        }

        .middle {
            float: left;
            width: 70%;
            margin-top: 10px;
            direction: rtl;
        }

        .chart {
            direction: ltr
        }

        /* The bar container */
        .bar-container {
            width: 100%;
            background-color: #f1f1f1;
            text-align: center;
            color: white;
        }

        /* Individual bars */
        .bar-5 {
            height: 18px;
            background-color: #04AA6D;
        }

        .bar-4 {
            height: 18px;
            background-color: #2196F3;
        }

        .bar-3 {
            height: 18px;
            background-color: #00bcd4;
        }

        .bar-2 {
            height: 18px;
            background-color: #ff9800;
        }

        .bar-1 {
            height: 18px;
            background-color: #f44336;
        }

        /* Responsive layout - make the columns stack on top of each other instead of next to each other */
        @media (max-width: 400px) {

            .side,
            .middle {
                width: 100%;
            }

            /* Hide the right column on small screens */
            .right {
                display: none;
            }
        }
    </style>
@endsection
@section('content')
    <!-- start cart -->
    <section class="mb-4">
        <section class="container-xxl">
            <section class="row">
                @if (session('alert-success'))
                    <div class="alert-success m-2 p-3">
                        {{ session('alert-success') }}
                    </div>
                @elseif (session('alert-error'))
                    <div class="alert alert-danger">
                        {{ session('alert-error') }}
                    </div>
                @endif
                <section class="col">
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>{{ $product->name }}</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        <!-- start image gallery -->
                        <section class="col-md-4">
                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">
                                <section class="product-gallery">
                                    <section class="product-gallery-selected-image mb-3">
                                        <img src="{{ asset($product->image['indexArray']['medium']) }}"
                                            alt="{{ $product->slug }}">
                                    </section>
                                    <section class="product-gallery-thumbs">
                                        <img class="product-gallery-thumb"
                                            src="{{ asset($product->image['indexArray']['medium']) }}"
                                            alt="{{ asset($product->image['indexArray']['medium'] . '-' . 0) }}"
                                            data-input="{{ asset($product->image['indexArray']['medium']) }}">
                                        @foreach ($product->galleries as $gallery)
                                            <img class="product-gallery-thumb"
                                                src="{{ asset($gallery->image['indexArray']['medium']) }}"
                                                alt="{{ asset($gallery->image['indexArray']['medium'] . '-' . $loop->iteration) }}"
                                                data-input="{{ asset($gallery->image['indexArray']['medium']) }}">
                                        @endforeach
                                    </section>
                                </section>
                            </section>
                        </section>
                        <!-- end image gallery -->

                        <!-- start product info -->
                        <section class="col-md-5">

                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                            {{ $product->name }}
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>
                                <form action="{{ route('home.sales-proccess.add-to-cart', $product->slug) }}"
                                    method="POST">
                                    @csrf
                                    <section class="product-info">

                                        <section class="d-flex">
                                            <p class="p-2"><i class="fa fa-star"></i>
                                                {{ persian(number_format($product->ratingsAvg(), 1, '/')) }} (
                                                {{ persian($product->ratingsCount()) }} )</p>
                                            <p class="p-2">( {{ persian($product->activeComments()->count()) }} ) دیدگاه
                                            </p>
                                        </section>

                                        @empty(!$product->colors()->first())
                                            @php
                                                $colors = $product->colors;
                                            @endphp
                                            <p><span>رنگ انتخاب شده : <span id="selected_color_name">
                                                        {{ $colors->first()->color_name }}</span></span></p>
                                        @endempty
                                        <p>
                                            @foreach ($product->colors as $key => $color)
                                                <label for="color-{{ $color->id }}"
                                                    style="background-color: {{ $color->color }};"
                                                    class="product-info-colors me-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="{{ $color->color_name }}"></label>

                                                <input class="d-none" type="radio" name="color"
                                                    data-color-name="{{ $color->color_name }}"
                                                    id="color-{{ $color->id }}" value='{{ $color->id }}'
                                                    data-color-price={{ $color->price_increase }}
                                                    @if ($loop->iteration == 1) checked @endif>
                                            @endforeach
                                        </p>
                                        @if ($product->guarantees->count() != 0)
                                            <p><i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                                گارانتی :
                                                <select name="guarantee" id="guarantee" class="p-1">
                                                    @foreach ($product->guarantees as $key => $guarantee)
                                                        <option value="{{ $guarantee->id }}"
                                                            data-guarantee-price={{ $guarantee->price_increase }}
                                                            @if ($key == 0) selected @endif>
                                                            {{ $guarantee->name }}</option>
                                                    @endforeach

                                                </select>
                                            </p>
                                        @endif
                                        @if ($product->marketable_number > 0)
                                            <p><i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا
                                                    موجود
                                                    در انبار</span></p>
                                        @else
                                            <p><i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا
                                                    موجود
                                                    نیست</span></p>
                                        @endif
                                        <div class="d-flex">
                                            {{-- favorite --}}
                                            @guest
                                                <section class="product-add-to-favorite position-relative my-2" style="top:0">
                                                    <button type="button" class="btn btn-light btn-sm text-decoration-none"
                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                        data-url="{{ route('home.product.add-favorite', $product) }}"
                                                        title="افزودن به علاقه مندی">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </section>
                                            @endguest
                                            @auth
                                                @if ($product->users->contains(auth()->user()->id))
                                                    <section class="product-add-to-favorite position-relative my-2"
                                                        style="top:0">
                                                        <button type="button"
                                                            class="add-to-favorite btn btn-light btn-sm text-decoration-none"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            data-url="{{ route('home.product.add-favorite', $product) }}"
                                                            title="حذف از علاقه مندی">
                                                            <i class="fa fa-heart text-danger"></i>
                                                        </button>
                                                    </section>
                                                @else
                                                    <section class="product-add-to-favorite position-relative my-2"
                                                        style="top:0">
                                                        <button type="button"
                                                            class="add-to-favorite btn btn-light btn-sm text-decoration-none"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            data-url="{{ route('home.product.add-favorite', $product) }}"
                                                            title="افزودن به علاقه مندی">
                                                            <i class="fa fa-heart"></i>
                                                        </button>
                                                    </section>
                                                @endif
                                            @endauth
                                            {{-- compare --}}
                                            @guest
                                                <section class="product-add-to-compare position-relative my-2" style="top:0">
                                                    <button type="button" class="btn btn-light btn-sm text-decoration-none"
                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                        data-url="{{ route('home.product.add-compare', $product) }}"
                                                        title="افزودن به مقایسه">
                                                        <i class="fa fa-industry"></i>
                                                    </button>
                                                </section>
                                            @endguest
                                            @auth
                                                @if (auth()->user()->compare && $product->compares->contains(auth()->user()->compare->id))
                                                    <section class="product-add-to-compare position-relative my-2"
                                                        style="top:0">
                                                        <button type="button"
                                                            class="add-to-compare btn btn-light btn-sm text-decoration-none"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            data-url="{{ route('home.product.add-compare', $product) }}"
                                                            title="حذف از مقایسه">
                                                            <i class="fa fa-industry text-danger"></i>
                                                        </button>
                                                    </section>
                                                @else
                                                    <section class="product-add-to-compare position-relative my-2"
                                                        style="top:0">
                                                        <button type="button"
                                                            class="add-to-compare btn btn-light btn-sm text-decoration-none"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            data-url="{{ route('home.product.add-compare', $product) }}"
                                                            title="افزودن به  مقایسه">
                                                            <i class="fa fa-industry"></i>
                                                        </button>
                                                    </section>
                                                @endif
                                            @endauth
                                        </div>
                                        <section>
                                            <section class="cart-product-number d-inline-block ">
                                                <button class="cart-number cart-number-down" type="button">-</button>
                                                <input class="" id="number" type="number" min="1"
                                                    max="5" step="1" value="1" readonly="readonly"
                                                    name="number">
                                                <button class="cart-number cart-number-up" type="button">+</button>
                                            </section>
                                        </section>
                                        <p class="mb-3 mt-5">
                                            <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز نهایی نشده است.
                                            برای
                                            ثبت سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را
                                            انتخاب
                                            کنید. نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت
                                            پرداخت این سفارش صورت میگیرد. پس از ثبت سفارش کالا بر اساس نحوه ارسال که شما
                                            انتخاب
                                            کرده اید کالا برای شما در مدت زمان مذکور ارسال می گردد.
                                        </p>
                                    </section>
                            </section>

                        </section>
                        <!-- end product info -->

                        <section class="col-md-3">
                            <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">قیمت کالا</p>
                                    <p class="text-muted"><span id="product-price"
                                            data-product-original-price={{ $product->price }}>{{ priceFormat($product->price) }}</span>
                                        <span class="small">تومان</span>
                                    </p>
                                </section>
                                @if (!empty($amazingSale))
                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">تخفیف کالا</p>
                                        <p class="text-danger fw-bolder" id="product-discount-price"
                                            data-product-discount-price="{{ $product->price * ($amazingSale->percentage / 100) }}">
                                            {{ priceFormat($product->price * ($amazingSale->percentage / 100)) }} <span
                                                class="small">تومان</span></p>
                                    </section>
                                @endif

                                <section class="border-bottom mb-3"></section>

                                <section class="d-flex justify-content-end align-items-center">
                                    <p class="fw-bolder"><span id="final-price"></span><span class="small">تومان</span>
                                    </p>
                                </section>
                                <section class="">
                                    @if ($product->marketable_number > 0)
                                        <button id="next-level" class="btn btn-danger d-block">افزودن به سبد
                                            خرید</button>
                                    @else
                                        <a id="next-level" href="#"
                                            class="btn btn-secondary disabled d-block">محصول
                                            موجود نمیباشد</a>
                                    @endif
                                </section>

                                </form>

                            </section>
                        </section>
                    </section>
                </section>
            </section>

        </section>
    </section>
    <!-- end cart -->


    @if ($reletedProducts->count() > 0)
        <!-- start product lazy load -->
        <section class="mb-4">
            <section class="container-xxl">
                <section class="row">
                    <section class="col">
                        <section class="content-wrapper bg-white p-3 rounded-2">
                            <!-- start vontent header -->
                            <section class="content-header">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title">
                                        <span>کالاهای مرتبط</span>
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                            <!-- start vontent header -->
                            <section class="lazyload-wrapper">
                                <section class="lazyload light-owl-nav owl-carousel owl-theme">

                                    @foreach ($reletedProducts as $reletedProduct)
                                        <section class="item">
                                            <section class="lazyload-item-wrapper">
                                                <section class="product">
                                                    {{-- <section class="product-add-to-cart"><a href="#"
                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a>
                                                </section> --}}

                                                    {{-- @guest

                                                        <section class="product-add-to-favorite">
                                                            <button
                                                                class="add-to-favorite btn btn-light btn-sm text-decoration-none"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                data-url="{{ route('home.product.add-favorite', $reletedProduct) }}"
                                                                title="حذف از علاقه مندی">
                                                                <i class="fa fa-heart text-danger"></i>
                                                            </button>
                                                        </section>
                                                    @else
                                                        <section class="product-add-to-favorite">
                                                            <button
                                                                class="add-to-favorite btn btn-light btn-sm text-decoration-none"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                data-url="{{ route('home.product.add-favorite', $reletedProduct) }}"
                                                                title="افزودن به علاقه مندی">
                                                                <i class="fa fa-heart"></i>
                                                            </button>
                                                        </section>

                                                    @endguest
                                                    @auth
                                                        @if ($reletedProduct->users->contains(auth()->user()->id))
                                                            <section class="product-add-to-favorite">
                                                                <button
                                                                    class="add-to-favorite btn btn-light btn-sm text-decoration-none"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    data-url="{{ route('home.product.add-favorite', $reletedProduct) }}"
                                                                    title="حذف از علاقه مندی">
                                                                    <i class="fa fa-heart text-danger"></i>
                                                                </button>
                                                            </section>
                                                        @else
                                                            <section class="product-add-to-favorite">
                                                                <button
                                                                    class="add-to-favorite btn btn-light btn-sm text-decoration-none"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    data-url="{{ route('home.product.add-favorite', $reletedProduct) }}"
                                                                    title="افزودن به علاقه مندی">
                                                                    <i class="fa fa-heart"></i>
                                                                </button>
                                                            </section>
                                                        @endif
                                                    @endauth --}}
                                                    <a class="product-link"
                                                        href="{{ route('home.product.index', $reletedProduct) }}">
                                                        <section class="product-image">
                                                            <img class=""
                                                                src="{{ asset($reletedProduct->image['indexArray'][$reletedProduct->image['currentImage']]) }}"
                                                                alt="{{ $reletedProduct->slug }}">
                                                        </section>
                                                        <section class="product-colors"></section>
                                                        <section class="product-name">
                                                            <h3>{{ Str::limit($reletedProduct->name, 20) }}</h3>
                                                        </section>
                                                        <section class="product-price-wrapper">
                                                            @if ($reletedProduct->activeAmazingSales())
                                                            <section class="product-discount">
                                                                <span
                                                                    class="product-old-price">{{ priceFormat($reletedProduct->price) }}
                                                                </span>
                                                                <span
                                                                    class="product-discount-amount">{{ persian($reletedProduct->activeAmazingSales()->percentage) }} %</span>
                                                            </section>
                                                            <section class="product-price">
                                                                {{ priceFormat($reletedProduct->price - $reletedProduct->amazingSaleDiscount()) }}
                                                            </section>
                                                        @else

                                                            <section class="product-price">
                                                                {{ priceFormat($reletedProduct->price) }}
                                                            </section>
                                                        @endif
                                                        </section>
                                                        <section class="product-colors">
                                                            @foreach ($reletedProduct->colors as $color)
                                                                <section class="product-colors-item"
                                                                    style="background-color: {{ $color->color }};">
                                                                </section>
                                                            @endforeach
                                                        </section>
                                                    </a>
                                                </section>

                                            </section>
                                        </section>
                                    @endforeach
                                </section>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
        <!-- end product lazy load -->
    @endif
    <!-- start description, features and comments -->
    <section class="mb-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <section class="content-wrapper bg-white p-3 rounded-2">
                        <!-- start content header -->
                        <section id="introduction-features-comments" class="introduction-features-comments" id="introduction">
                            <section class="content-header">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title">
                                        <span class="me-2"><a class="text-decoration-none text-dark"
                                                href="#introduction">معرفی</a></span>
                                        <span class="me-2"><a class="text-decoration-none text-dark"
                                                href="#features">ویژگی ها</a></span>
                                        <span class="me-2"><a class="text-decoration-none text-dark"
                                                href="#comments">دیدگاه ها</a></span>
                                        <span class="me-2"><a class="text-decoration-none text-dark"
                                                href="#rating">امتیاز ها</a></span>
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                        </section>
                        <!-- start content header -->

                        <section class="py-4">

                            <!-- start vontent header -->
                            <section id="introduction" class="content-header mt-2 mb-4">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        معرفی
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                            <section class="product-introduction mb-4">
                                {!! $product->introduction !!}
                            </section>

                            <!-- start vontent header -->
                            <section id="features" class="content-header mt-2 mb-4">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        ویژگی ها
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                            <section class="product-features mb-4 table-responsive">
                                <table class="table table-bordered border-white">
                                    @foreach ($product->values as $value)
                                        <tr>
                                            <td>{{ $value->attribute->name }}</td>
                                            <td>{{ persian($value->value) }} {{ $value->attribute->unit ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                    @foreach ($product->metas as $meta)
                                        <tr>
                                            <td>{{ $meta->meta_key }}</td>
                                            <td>{{ $meta->meta_value }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </section>

                            <!-- start vontent header -->
                            <section id="comments" class="content-header mt-2 mb-4">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        دیدگاه ها
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                            <section class="product-comments mb-4">

                                <section class="comment-add-wrapper">
                                    <button class="comment-add-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-comment"><i class="fa fa-plus"></i> افزودن دیدگاه</button>
                                    <!-- start add comment Modal -->
                                    <section class="modal fade" id="add-comment" tabindex="-1"
                                        aria-labelledby="add-comment-label" aria-hidden="true">
                                        <section class="modal-dialog">
                                            <section class="modal-content">
                                                <section class="modal-header">
                                                    <h5 class="modal-title" id="add-comment-label"><i
                                                            class="fa fa-plus"></i> افزودن دیدگاه</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </section>
                                                @guest
                                                    <section class="modal-body">
                                                        <p>برای ثبت نظر، ابتدا باید به حساب کاربری خود وارد شوید</p>
                                                        <p>برای وارد شدن <a
                                                                href="{{ route('auth.customer.login-register-form') }}">کلیک
                                                                کنید.</a></p>
                                                    </section>

                                                @endguest
                                                @auth
                                                    <section class="modal-body">
                                                        <form class="row"
                                                            action="{{ route('home.product.add-comment', $product->id) }}">

                                                            {{-- <section class="col-6 mb-2">
                                                                <label for="first_name" class="form-label mb-1">نام</label>
                                                                <input type="text" class="form-control form-control-sm" id="first_name" placeholder="نام ...">
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="last_name" class="form-label mb-1">نام خانوادگی</label>
                                                                <input type="text" class="form-control form-control-sm" id="last_name" placeholder="نام خانوادگی ...">
                                                            </section> --}}

                                                            <section class="col-12 mb-2">
                                                                <label for="comment" class="form-label mb-1">دیدگاه
                                                                    شما</label>
                                                                <textarea class="form-control form-control-sm" id="comment" placeholder="دیدگاه شما ..." rows="4"
                                                                    name="body"></textarea>
                                                            </section>
                                                            <section class="modal-footer py-1">
                                                                <button type="submit" class="btn btn-sm btn-primary">ثبت
                                                                    دیدگاه</button>
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    data-bs-dismiss="modal">بستن</button>
                                                            </section>
                                                        </form>
                                                    </section>
                                                @endauth
                                            </section>
                                        </section>
                                    </section>
                                </section>

                                @foreach ($comments as $comment)
                                    <section class="product-comment">
                                        <section class="product-comment-header d-flex justify-content-start">
                                            <section class="product-comment-date">{{ jalaliDate($comment->created_at) }}
                                            </section>
                                            <section class="product-comment-title">
                                                {{ $comment->user->fullName == ' ' ? 'ناشناس' : $comment->user->fullName }}
                                            </section>
                                        </section>
                                        <section
                                            class="product-comment-body @if ($comment->awnsers) border-bottom @endif">
                                            {{ $comment->body }}
                                        </section>

                                        @foreach ($comment->answers as $answer)
                                            <section class="product-comment">
                                                <section class="product-comment-header d-flex justify-content-start">
                                                    <section class="product-comment-date">
                                                        {{ jalaliDate($answer->created_at) }}</section>
                                                    <section class="product-comment-title">
                                                        {{ $answer->user->fullName == ' ' ? 'ناشناس' : $answer->user->fullName }}
                                                    </section>
                                                </section>
                                                <section class="product-comment-body">
                                                    {{ $answer->body }}
                                                </section>
                                            </section>
                                            @foreach ($answer->answers as $answer)
                                                <section class="product-comment">
                                                    <section class="product-comment-header d-flex justify-content-start">
                                                        <section class="product-comment-date">
                                                            {{ jalaliDate($answer->created_at) }}</section>
                                                        <section class="product-comment-title">
                                                            {{ $answer->user->fullName == ' ' ? 'ناشناس' : $answer->user->fullName }}
                                                        </section>
                                                    </section>
                                                    <section class="product-comment-body">
                                                        {{ $answer->body }}
                                                    </section>
                                                </section>
                                            @endforeach
                                        @endforeach
                                    </section>
                                @endforeach
                            </section>

                            <section id="rating" class="content-header mt-2 mb-4">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        امتیاز ها
                                    </h2>
                                </section>
                            </section>


                            <section class="product-comments mb-3 d-flex justify-content-around align-items-center flex-wrap">
                                @auth
                                    @if (auth()->user()->userProductPurchase()->contains($product->id))
                                        <div class="container d-inline-block" style="width: 50%" id="star-rating">

                                            <h5 class="text-danger">
                                                امتیاز خود را به این محصول انتخاب نمایید
                                            </h5>
                                            <form
                                                class="starrating risingstar d-flex justify-content-end flex-row-reverse align-items-center"
                                                action="{{ route('home.product.add-rate', $product) }}" method="post">
                                                @csrf
                                                <div class="mx-3">
                                                    <button class="btn btn-info btn-sm">ثبت امتیاز</button>
                                                </div>
                                                <input type="radio" id="star5" name="rating" value="5" />
                                                <label for="star5" title="5 star"></label>
                                                <input type="radio" id="star4" name="rating" value="4" />
                                                <label for="star4" title="4 star"></label>
                                                <input type="radio" id="star3" name="rating" value="3" />
                                                <label for="star3" title="3 star"></label>
                                                <input type="radio" id="star2" name="rating" value="2" />
                                                <label for="star2" title="2 star"></label>
                                                <input type="radio" id="star1" name="rating" value="1" />
                                                <label for="star1" title="1 star"></label>

                                            </form>
                                            <h6>
                                                میانگین امتیاز :
                                                {{ number_format($product->ratingsAvg(), 1, '/') ??
                                                    'شما اولین
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        امتیاز را ثبت نمایید!!!' }}
                                            </h6>
                                            <h6>
                                                تعداد افراد شرکت کننده :
                                                {{ $product->ratingsCount() ??
                                                    'شما اولین امتیاز را ثبت
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        نمایید!!!' }}
                                            </h6>
                                        </div>
                                    @else
                                        <p>برای ثبت امتیاز، ابتدا باید محصول را خریداری کنید</p>
                                    @endif
                                @endauth
                                @guest
                                    <section class="modal-body">
                                        <p>برای ثبت امتیاز ابتدا باید به حساب کاربری خود وارد شوید</p>
                                        <p>برای وارد شدن <a href="{{ route('auth.customer.login-register-form') }}">کلیک
                                                کنید.</a></p>
                                    </section>
                                @endguest
                                <section id="rating-chart">
                                    <section class="chart">
                                        @for ($i = 5; $i > 0; $i--)
                                        <div class="side">
                                            <div> {{$i}} ستاره </div>
                                        </div>
                                        <div class="middle">
                                            <div class="bar-container">
                                                <div class="bar-{{$i}}"
                                                    style="width: {{ ($ratings->countBy('value')[$i] ?? 0) * 100 / ($product->ratingsCount() == 0 ? 1 : $product->ratingsCount()) }}%;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="side right">
                                            <div>{{ $ratings->countBy('value')[$i] ?? 0 }}</div>
                                        </div>
                                        @endfor
                                    </section>
                                </section>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <!-- end description, features and comments -->

    <section class="position-fixed p-4 flex-row-reverse" style="right: 0; top: 3rem; width: 26rem; max-width: 80%;">
        <div class="toast d-none" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">فروشگاه</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <strong class="ml-auto">
                    برای افزودن کالا به لیست علاقه مندی ها یا مقایسه ها باید ابتدا وارد حساب کاربری خود شوید
                    <br>
                    <a href="{{ route('auth.customer.login-register-form') }}" class="text-dark">
                        ثبت نام / ورود
                    </a>
                </strong>
            </div>
    </section>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            bill();
            //input color
            $('input[name="color"]').change(function() {
                bill();
            })
            //guarantee
            $('select[name="guarantee"]').change(function() {
                bill();
            })
            //number
            $('.cart-number').click(function() {
                bill();
            })
        })

        function bill() {
            if ($('input[name="color"]:checked').length != 0) {
                var selected_color = $('input[name="color"]:checked');
                $("#selected_color_name").html(selected_color.attr('data-color-name'));
            }

            //price computing
            var selected_color_price = 0;
            var selected_guarantee_price = 0;
            var number = 1;
            var product_discount_price = 0;
            var product_original_price = parseFloat($('#product-price').attr('data-product-original-price'));

            if ($('input[name="color"]:checked').length != 0) {
                selected_color_price = parseFloat(selected_color.attr('data-color-price'));
            }

            if ($('#guarantee option:selected').length != 0) {
                selected_guarantee_price = parseFloat($('#guarantee option:selected').attr('data-guarantee-price'));
            }

            if ($('#number').val() > 0) {
                number = parseFloat($('#number').val());
            }

            if ($('#product-discount-price').length != 0) {
                product_discount_price = parseFloat($('#product-discount-price').attr('data-product-discount-price'));
            }

            //final price
            var product_price = product_original_price + selected_color_price + selected_guarantee_price;
            var final_price = number * (product_price - product_discount_price);
            $('#product-price').html(toFarsiNumber(product_price));
            $('#final-price').html(toFarsiNumber(final_price));
        }

        function toFarsiNumber(number) {
            const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            // add comma
            number = new Intl.NumberFormat().format(number);
            //convert to persian
            return number.toString().replace(/\d/g, x => farsiDigits[x]);
        }
    </script>
    <script>
        $('.product-add-to-favorite button').click(function() {
            var url = $(this).attr('data-url');
            var element = $(this);
            $.ajax({
                url: url,
                success: function(result) {
                    if (result.status == 1) {
                        $(element).children().first().addClass('text-danger');
                        $(element).attr('data-original-title', 'حذف از علاقه مندی ها');
                        $(element).attr('data-bs-original-title', 'حذف از علاقه مندی ها');
                    } else if (result.status == 2) {
                        $(element).children().first().removeClass('text-danger')
                        $(element).attr('data-original-title', 'افزودن از علاقه مندی ها');
                        $(element).attr('data-bs-original-title', 'افزودن از علاقه مندی ها');
                    } else if (result.status == 3) {
                         $('.toast').removeClass('d-none');
                        $('.toast').toast('show');
                        setTimeout(function () {
                            $('.toast').addClass('d-none');
                        }, 10000);
                    }
                }
            })
        })
    </script>
    <script>
        $('.product-add-to-compare button').click(function() {
            var url = $(this).attr('data-url');
            var element = $(this);
            $.ajax({
                url: url,
                success: function(result) {
                    if (result.status == 1) {
                        $(element).children().first().addClass('text-danger');
                        $(element).attr('data-original-title', 'حذف از مقایسه');
                        $(element).attr('data-bs-original-title', 'حذف از مقایسه');
                    } else if (result.status == 2) {
                        $(element).children().first().removeClass('text-danger')
                        $(element).attr('data-original-title', 'افزودن به مقایسه');
                        $(element).attr('data-bs-original-title', 'افزودن به مقایسه');
                    } else if (result.status == 3) {
                        $('.toast').toast('show');
                    } else if (result.status == 4) {
                        alert('بیشتر از 3 محصول نمیتوانید به مقایسه ها اضافه کنید');
                    }
                }
            })
        })
    </script>
    <script>
        //start product introduction, features and comment
        $(document).ready(function() {
            var s = $("#introduction-features-comments");
            var pos = s.position();
            $(window).scroll(function() {
                var windowpos = $(window).scrollTop();

                if (windowpos >= pos.top) {
                    s.addClass("stick");
                } else {
                    s.removeClass("stick");
                }
            });
            if (screen.width > 0 && screen.width < 480) {
                var content = $('#introduction-features-comments');
                content.addClass('d-none');
                var chart= $('#rating-chart');
                chart.css({'width': '100%'});
                var star_rating = $('#star-rating');
                star_rating.css({
                    'width': '100%',
                });
                star_rating.children().css({'font-size': '13px'});
                console.log(star_rating.children())

                
            }
        });
        //end product introduction, features and comment
    </script>
@endsection
