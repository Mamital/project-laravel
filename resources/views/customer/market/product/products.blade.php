@extends('customer.layouts.master-two-col')
@section('head-tag')
    <title>محصولات</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
@endsection

@section('customer.layouts.sidebar')
    <aside id="sidebar" class="sidebar col-md-3">

        <form action="{{ route('home.products', request()->productCategory ?? null) }}" method="get" id="filter">
            <input type="hidden" name="sort" value="{{ request()->sort }}">
            <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                <!-- start sidebar nav-->
                <section class="sidebar-nav">
                   
                    @include('customer.market.product.partial.categories', ['categories' => $categories])

                </section>
                <!--end sidebar nav-->
            </section>

            <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                <section class="content-header mb-3">
                    <section class="d-flex justify-content-between align-items-center">
                        <h2 class="content-header-title content-header-title-small">
                            جستجو در نتایج
                        </h2>
                        <section class="content-header-link">
                            <!--<a href="#">مشاهده همه</a>-->
                        </section>
                    </section>
                </section>

                <section class="">
                    <input class="sidebar-input-text" type="text" name="search" value="{{ request()->search }}"
                        placeholder="جستجو بر اساس نام، برند ...">
                </section>
            </section>

            <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                <section class="content-header mb-3">
                    <section class="d-flex justify-content-between align-items-center">
                        <h2 class="content-header-title content-header-title-small">
                            برند
                        </h2>
                        <section class="content-header-link">
                            <!--<a href="#">مشاهده همه</a>-->
                        </section>
                    </section>
                </section>

                @foreach ($brands as $brand)
                    <section class="sidebar-brand-wrapper">
                        <section class="form-check sidebar-brand-item">
                            <input class="form-check-input" type="checkbox" name="brands[]"
                                @if (request()->brands && in_array($brand->id, request()->brands)) checked @endif value="{{ $brand->id }}"
                                id="{{ $brand->id }}">
                            <label class="form-check-label d-flex justify-content-between" for="{{ $brand->id }}">
                                <span>{{ $brand->persian_name }}</span>
                                <span>{{ $brand->original_name }}</span>
                            </label>
                        </section>
                    </section>
                @endforeach

            </section>



            <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                <section class="content-header mb-3">
                    <section class="d-flex justify-content-between align-items-center">
                        <h2 class="content-header-title content-header-title-small">
                            محدوده قیمت
                        </h2>
                        <section class="content-header-link">
                            <!--<a href="#">مشاهده همه</a>-->
                        </section>
                    </section>
                </section>
                <section class="sidebar-price-range d-flex justify-content-between">
                    <section class="p-1"><input type="text" name="min_price" value="{{ request()->min_price }}"
                            placeholder="قیمت از ..."></section>
                    <section class="p-1"><input type="text" name="max_price" value="{{ request()->max_price }}"
                            placeholder="قیمت تا ..."></section>
                </section>
            </section>



            <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                <section class="sidebar-filter-btn d-grid gap-2">
                    <button class="btn btn-danger" type="submit">اعمال فیلتر</button>
                </section>
        </form>
        </section>


    </aside>
@endsection

@section('content')
    <main id="main-body" class="main-body col-md-9">
        <section class="content-wrapper bg-white p-3 rounded-2 mb-2">
            <section class="filters mb-3">
                @if (request()->search)
                    <span class="d-inline-block border p-1 rounded bg-light">نتیجه جستجو برای :<span
                            class="badge bg-info text-dark">"{{ request()->search }}"</span>
                            <a href="{{route('home.products', ['search' => null, 'sort' => 1, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands, request()->productCategory ?? null]) }}" ><i class="fa fa-close red-color"></i></a>
                        </span>
                @endif
                @if (request()->brands)
                    <span class="d-inline-block border p-1 rounded bg-light">برند : 
                        <span class="badge bg-info text-dark">"{{ implode(', ', $selected_brands) }}"</span>
                        <a href="{{route('home.products', ['search' => request()->search, 'sort' => 1, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => null, request()->productCategory ?? null]) }}" ><i class="fa fa-close red-color"></i></a>
                    </span>
                @endif
                @if (request()->productCategory)
                    <span class="d-inline-block border p-1 rounded bg-light">دسته : <span
                            class="badge bg-info text-dark">"{{ request()->productCategory->name }}"</span>
                            <a href="{{route('home.products', ['search' => request()->search, 'sort' => 1, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands, request()->productCategory = null]) }}" ><i class="fa fa-close red-color"></i></a>
                        </span>
                @endif
                @if (request()->min_price)
                    <span class="d-inline-block border p-1 rounded bg-light">قیمت از : <span
                            class="badge bg-info text-dark"> {{ request()->min_price }} تومان</span>
                        <a href="{{route('home.products', ['search' => request()->search, 'sort' => 1, 'min_price' => null, 'max_price' => request()->max_price, 'brands' => request()->brands, request()->productCategory ?? null]) }}" ><i class="fa fa-close red-color"></i></a>
                    </span>
                @endif
                @if (request()->max_price)
                    <span class="d-inline-block border p-1 rounded bg-light">قیمت تا : <span
                            class="badge bg-info text-dark"> {{ request()->max_price }} تومان</span>
                            <a href="{{route('home.products', ['search' => request()->search, 'sort' => 1, 'min_price' => request()->min_price, 'max_price' => null, 'brands' => request()->brands, request()->productCategory ?? null]) }}" ><i class="fa fa-close red-color"></i></a>
                        </span>
                @endif
            </section>
            <section class="sort ">
                <span>مرتب سازی بر اساس : </span>
                <a class="btn {{ request()->sort == 1 ? 'btn-info' : 'btn-light' }} btn-sm px-1 py-0"
                    href="{{ route('home.products', ['search' => request()->search, 'sort' => 1, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands, request()->productCategory ?? null]) }}">جدیدترین</a>
                <a class="btn {{ request()->sort == 2 ? 'btn-info' : 'btn-light' }} btn-sm px-1 py-0"
                    href="{{ route('home.products', ['search' => request()->search, 'sort' => 2, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands, request()->productCategory ?? null]) }}">گران
                    ترین</a>
                <a class="btn {{ request()->sort == 3 ? 'btn-info' : 'btn-light' }} btn-sm px-1 py-0"
                    href="{{ route('home.products', ['search' => request()->search, 'sort' => 3, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands, request()->productCategory ?? null]) }}">ارزان
                    ترین</a>
                <a class="btn {{ request()->sort == 4 ? 'btn-info' : 'btn-light' }} btn-sm px-1 py-0"
                    href="{{ route('home.products', ['search' => request()->search, 'sort' => 4, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands, request()->productCategory ?? null]) }}">پربازدیدترین</a>
                <a class="btn {{ request()->sort == 5 ? 'btn-info' : 'btn-light' }} btn-sm px-1 py-0"
                    href="{{ route('home.products', ['search' => request()->search, 'sort' => 5, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands, request()->productCategory ?? null]) }}">پرفروش
                    ترین</a>
            </section>


            <section class="main-product-wrapper row my-4">

                @forelse ($products as $product)
                    <section class="col-md-3 p-0">
                        <section class="product">
                            {{-- <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip"
                                    data-bs-placement="left" title="افزودن به سبد خرید"><i
                                        class="fa fa-cart-plus"></i></a></section>
                            <section class="product-add-to-favorite"><a href="#" data-bs-toggle="tooltip"
                                    data-bs-placement="left" title="افزودن به علاقه مندی"><i class="fa fa-heart"></i></a>
                            </section> --}}
                            <a class="product-link" href="{{route('home.product.index', $product->slug)}}">
                                <section class="product-image">
                                    <img class="" src="{{ asset($product->image['indexArray']['medium']) }}"
                                        alt="{{ $product->slug }}">
                                </section>
                                <section class="product-colors"></section>
                                <section class="product-name">
                                    <h3>{{ $product->name }}</h3>
                                </section>
                                <section class="product-price-wrapper">
                                    <section class="product-price">{{ priceFormat($product->price) }}</section>
                                </section>
                            </a>
                        </section>
                    </section>
                @empty
                    محصولی یافت نشد
                @endforelse

                <section class="col-12">
                    <section class="my-4 d-flex justify-content-center">
                        <nav>
                            {{ $products->links('pagination::bootstrap-5') }}
                        </nav>
                    </section>
                </section>

            </section>


        </section>
    </main>
@endsection
