@extends('customer.layouts.master-two-col')
@section('head-tag')
    <title>علاقه مندی های من</title>
@endsection

@section('customer.layouts.sidebar')
    @include('customer.profile.sidebar')
@endsection
@section('content')
    <main id="main-body" class="main-body col-md-9">
        <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

            <!-- start vontent header -->
            <section class="content-header mb-4">
                <section class="d-flex justify-content-between align-items-center">
                    <h2 class="content-header-title">
                        <span>لیست علاقه های من</span>
                    </h2>
                    <section class="content-header-link">
                        <!--<a href="#">مشاهده همه</a>-->
                    </section>
                </section>
            </section>
            <!-- end vontent header -->

            @forelse ($products as $product)
                <section class="cart-item d-flex py-3">
                    <section class="cart-img align-self-start flex-shrink-1"><img
                            src="{{ asset($product->image['indexArray']['medium']) }}" alt=""></section>
                    <section class="align-self-start w-100">
                        <p class="fw-bold"> {{ $product->name }} </p>
                        <p><i class="fa fa-store-alt cart-product-selected-store me-1"></i>
                            <span>{{ $product->marketable_number > 0 ? 'موجود در انبار' : 'کالا موجود نیست' }}</span>
                        </p>
                        <section>
                            <a class="text-decoration-none cart-delete"
                                href="{{ route('home.profile.my-favorite.delete', $product) }}"><i
                                    class="fa fa-trash-alt"></i> حذف از لیست علاقه ها</a>
                        </section>
                    </section>
                    <section class="align-self-end flex-shrink-1">
                        @if (!empty($product->activeAmazingSales()))
                            <section class="cart-item-discount text-danger text-nowrap mb-1">
                                {{ priceFormat($product->amazingSaleDiscount()) }}
                                تخفیف
                            </section>
                        @endif
                        <section class="text-nowrap fw-bold">
                            {{ priceFormat($product->price - $product->amazingSaleDiscount()) }}
                            تومان</section>
                    </section>
                </section>

            @empty
                <p>هیچ محصولی در در علاقه مندی ها موجود نیست</p>
            @endforelse

        </section>
    </main>
@endsection
