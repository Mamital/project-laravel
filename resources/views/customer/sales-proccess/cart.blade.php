@extends('customer.layouts.master-one-col')

@section('head-tag')
    <title>سبد خرید</title>
@endsection

@section('content')
    <!-- start cart -->
    <section class="mb-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>سبد خرید شما</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        <section class="col-md-9 mb-3">
                            <form action="{{route('home.sales-proccess.update-cart')}}" method="post" id="cart_items" class="content-wrapper bg-white p-3 rounded-2">
                                @csrf
                                @php
                                    $totalProductPrice = 0;
                                    $totalProductDiscount = 0;
                                @endphp
                                @foreach ($cartItems as $cartItem)
                                    @php
                                        $totalProductPrice += $cartItem->cartItemProductPrice();
                                        $totalProductDiscount += $cartItem->cartItemProductDiscount();
                                    @endphp

                                    <section class="cart-item d-md-flex py-3">
                                        <section class="cart-img align-self-start flex-shrink-1"><img
                                                src="{{ $cartItem->product->image['indexArray']['medium'] }}"
                                                alt=""></section>
                                        <section class="align-self-start w-100">
                                            <p class="fw-bold">{{ $cartItem->product->name }}</p>
                                            <p><span style="background-color: {{ $cartItem->color->color ?? '#000000' }};"
                                                    class="cart-product-selected-color me-1"></span> <span>
                                                    {{ $cartItem->color->color_name ?? 'کالا فاقد رنگ منتخب میباشد' }}</span>
                                            </p>
                                            <p><i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i> <span>
                                                    {{ $cartItem->guarantee->name ?? 'کالا فاقد گارانتی مخنتب میباشد' }}</span>
                                            </p>
                                            <p><i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا
                                                    موجود در انبار</span></p>
                                            <section>
                                                <section class="cart-product-number d-inline-block ">
                                                    <button class="cart-number cart-number-down" type="button">-</button>
                                                    <input class="number" 
                                                    name="number[{{$cartItem->id}}]"
                                                        data-product-price={{ $cartItem->cartItemProductPrice() }}
                                                        data-product-discount={{ $cartItem->cartItemProductDiscount() }}
                                                        type="number" min="1" max="5" step="1"
                                                        value="{{ $cartItem->number }}" readonly="readonly">
                                                    <button class="cart-number cart-number-up" type="button">+</button>
                                                </section>
                                                <a class="text-decoration-none ms-4 cart-delete" href="{{route('home.sales-proccess.remove-from-cart', $cartItem)}}"><i
                                                        class="fa fa-trash-alt"></i> حذف از سبد</a>
                                            </section>
                                        </section>
                                        <section class="align-self-end flex-shrink-1">
                                            @if (!empty($cartItem->product->activeAmazingSales()))
                                                <section class="cart-item-discount text-danger text-nowrap mb-1">
                                                    {{ priceFormat($cartItem->cartItemProductDiscount()) }} تخفیف
                                                </section>
                                            @endif
                                            <section class="text-nowrap fw-bold">
                                                {{ priceFormat($cartItem->cartItemProductPrice()) }} تومان</section>
                                        </section>
                                    </section>
                                @endforeach
                            </form>
                        </section>
                        <section class="col-md-3">
                            <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">قیمت کالاها ({{$cartItems->count()}})</p>
                                    <p class="text-muted" id="total-product-price">{{ priceFormat($totalProductPrice) }}
                                    </p>
                                </section>

                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">تخفیف کالاها</p>
                                    <p class="text-danger fw-bolder" id="total-product-discount">
                                        {{ priceFormat($totalProductDiscount) }}</p>
                                </section>
                                <section class="border-bottom mb-3"></section>
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">جمع سبد خرید</p>
                                    <p class="fw-bolder" id="total-price">
                                        {{ priceFormat($totalProductPrice - $totalProductDiscount) }}</p>
                                </section>

                                <p class="my-3">
                                    <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز نهایی نشده است. برای ثبت
                                    سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را انتخاب کنید.
                                    نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت پرداخت این
                                    سفارش صورت میگیرد.
                                </p>


                                <section class="">
                                    <button onclick="document.getElementById('cart_items').submit()" class="btn btn-danger d-block">تکمیل فرآیند خرید</button>
                                </section>

                            </section>
                        </section>
                    </section>
                </section>
            </section>

        </section>
    </section>
    <!-- end cart -->




    <section class="mb-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <section class="content-wrapper bg-white p-3 rounded-2">
                        <!-- start vontent header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>کالاهای مرتبط با سبد خرید شما</span>
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
                                                <section class="product-add-to-cart"><a href="#"
                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a>
                                                </section>
                                                @guest
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
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
                                                @endauth
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
                                                        {{-- <section class="product-discount">
                                                            <span class="product-old-price">6,895,000 </span>
                                                            <span class="product-discount-amount">10%</span>
                                                        </section> --}}
                                                        <section class="product-price">
                                                            {{ priceFormat($reletedProduct->price) }}</section>
                                                    </section>
                                                    <section class="product-colors">
                                                        @foreach ($reletedProduct->colors as $color)
                                                            <section class="product-colors-item"
                                                                style="background-color: {{ $color->color }};"></section>
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
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            bill();

            $('.cart-number').click(function() {
                bill();
            });

            function bill() {
                var total_product_price = 0;
                var total_discount = 0;
                var total_price = 0;

                $('.number').each(function() {

                    var product_price = parseFloat($(this).data('product-price'));
                    var product_discount = parseFloat($(this).data('product-discount'));
                    var number = parseFloat($(this).val());

                    total_product_price += product_price * number;
                    total_discount += product_discount * number;

                });

                total_price = total_product_price - total_discount;

                $('#total-product-price').html(toFarsiNumber(total_product_price));
                $('#total-product-discount').html(toFarsiNumber(total_discount));
                $('#total-price').html(toFarsiNumber(total_price));

                function toFarsiNumber(number) {
                    const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                    // add comma
                    number = new Intl.NumberFormat().format(number);
                    //convert to persian
                    return number.toString().replace(/\d/g, x => farsiDigits[x]);
                }

            }
        });
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
                        $('.toast').toast('show');
                    }
                }
            })
        })
    </script>
@endsection
