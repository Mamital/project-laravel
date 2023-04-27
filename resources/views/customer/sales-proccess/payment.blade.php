@extends('customer.layouts.master-one-col')
@section('head-tag')
    <title>پرداخت</title>
@endsection
@section('content')
    <main id="main-body-one-col" class="main-body">

        <!-- start cart -->
        <section class="mb-4">
            <section class="container-xxl">
                <section class="row">

                    @if (session('copan-success'))
                        <div class="alert alert-success">
                            {{session('copan-success')}}
                        </div>
                    @elseif (session('copan-error'))
                        <div class="alert alert-danger">
                            {{session('copan-error')}}
                        </div>
                    @endif

                    <section class="col">
                        <!-- start vontent header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>انتخاب نوع پرداخت </span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>

                        <section class="row mt-4">
                            <section class="col-md-9">
                                <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                    <!-- start vontent header -->
                                    <section class="content-header mb-3">
                                        <section class="d-flex justify-content-between align-items-center">
                                            <h2 class="content-header-title content-header-title-small">
                                                کد تخفیف
                                            </h2>
                                            <section class="content-header-link">
                                                <!--<a href="#">مشاهده همه</a>-->
                                            </section>
                                        </section>
                                    </section>

                                    <section class="payment-alert alert alert-primary d-flex align-items-center p-2"
                                        role="alert">
                                        <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                        <secrion>
                                            کد تخفیف خود را در این بخش وارد کنید.
                                        </secrion>
                                    </section>

                                    <section class="row">
                                        <section class="col-md-5">
                                            <form action="{{ route('home.sales-proccess.copan-discount') }}" method="POST">
                                                @csrf
                                                <section class="input-group input-group-sm">
                                                    <input name="copan" type="text" class="form-control"
                                                        placeholder="کد تخفیف را وارد کنید">
                                                        <button class="btn btn-primary" type="submit">اعمال کد</button>
                                                    </section>
                                            </form>
                                        </section>

                                    </section>
                                </section>


                                <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                    <!-- start vontent header -->
                                    <section class="content-header mb-3">
                                        <section class="d-flex justify-content-between align-items-center">
                                            <h2 class="content-header-title content-header-title-small">
                                                انتخاب نوع پرداخت
                                            </h2>
                                            <section class="content-header-link">
                                                <!--<a href="#">مشاهده همه</a>-->
                                            </section>
                                        </section>
                                    </section>
                                    <section class="payment-select">

                                        <form action="{{route('home.sales-proccess.payment-submit')}}" id="payment_submit" method="post">
                                        @csrf

                                        <section class="payment-alert alert alert-primary d-flex align-items-center p-2"
                                            role="alert">
                                            <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                            <secrion>
                                                برای پیشگیری از انتقال ویروس کرونا پیشنهاد می کنیم روش پرداخت اینترنتی رو
                                                پرداخت کنید.
                                            </secrion>
                                        </section>

                                        <input type="radio" name="payment_type" value="1" id="d1" />
                                        <label for="d1" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                            <section class="mb-2">
                                                <i class="fa fa-credit-card mx-1"></i>
                                                پرداخت آنلاین
                                            </section>
                                            <section class="mb-2">
                                                <i class="fa fa-calendar-alt mx-1"></i>
                                                درگاه پرداخت زرین پال
                                            </section>
                                        </label>

                                        <section class="mb-2"></section>

                                        <input type="radio" name="payment_type" value="2" id="d2"/>
                                        <label for="d2" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                            <section class="mb-2">
                                                <i class="fa fa-id-card-alt mx-1"></i>
                                                پرداخت آفلاین
                                            </section>
                                            <section class="mb-2">
                                                <i class="fa fa-calendar-alt mx-1"></i>
                                                حداکثر در 2 روز کاری بررسی می شود
                                            </section>
                                        </label>

                                        <section class="mb-2"></section>

                                        <input type="radio" id="cash_payment" name="payment_type" value="3" />
                                        <label for="cash_payment" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                            <section class="mb-2">
                                                <i class="fa fa-money-check mx-1"></i>
                                                پرداخت در محل
                                            </section>
                                            <section class="mb-2">
                                                <i class="fa fa-calendar-alt mx-1"></i>
                                                پرداخت به پیک هنگام دریافت کالا
                                            </section>
                                        </label>


                                    </section>
                                </section>

                                
                            @php
                                $totalProductPrice = 0;
                            @endphp

                            @foreach ($cartItems as $cartItem)
                                @php
                                    $totalProductPrice += $cartItem->cartItemProductPrice() * $cartItem->number;
                                @endphp
                            @endforeach


                            </section>
                             <section class="col-md-3">
                            <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">قیمت کالاها ({{ $cartItems->count() }})</p>
                                    <p class="text-muted">{{ priceFormat($totalProductPrice) }} تومان</p>
                                </section>

                                @if ($order->order_discount_amount > 0)

                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">تخفیف کالاها</p>
                                    <p class="text-danger fw-bolder">{{ priceFormat($order->order_discount_amount) }} تومان</p>
                                </section>

                                @endif

                                @if ($order->order_common_discount_amount > 0)
                                
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">تخفیف عمومی</p>
                                    <p class="text-danger fw-bolder">{{ priceFormat($order->order_common_discount_amount) }} تومان</p>
                                </section>

                                @endif

                                @if ($order->order_copan_discount_amount > 0)
                                    
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">تخفیف کوپن</p>
                                    <p class="text-danger fw-bolder">{{ priceFormat($order->order_copan_discount_amount) }} تومان</p>
                                </section>

                                @endif

                                <section class="border-bottom mb-3"></section>

                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">جمع سبد خرید</p>
                                    <p class="fw-bolder">{{ priceFormat($totalProductPrice) }} تومان</p>
                                </section>
                                @if($order->order_total_products_discount_amount > 0)
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">جمع تخفیف ها</p>
                                    <p class="text-danger fw-bolder">{{ priceFormat($order->order_total_products_discount_amount) }} تومان</p>
                                </section>

                                @endif

                                {{-- <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">هزینه ارسال</p>
                                    <p class="text-warning">x3500 تومان</p>
                                </section> --}}

                                <p class="my-3">
                                    <i class="fa fa-info-circle me-1"></i> کاربر گرامی کالاها بر اساس نوع ارسالی که انتخاب
                                    می کنید در مدت زمان ذکر شده ارسال می شود.
                                </p>

                                <section class="border-bottom mb-3"></section>

                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">مبلغ قابل پرداخت</p>
                                    <p class="fw-bold">{{priceFormat($order->order_final_amount)}}</p>
                                </section>

                                    
                                    <button type="submit" id="next-level" class="btn btn-danger w-100">ادامه فرآیند
                                        خرید</button>
                                        </form>

                            </section>
                        </section>
                        </section>
                    </section>
                </section>

            </section>
        </section>
        <!-- end cart -->



    </main>
@endsection
@section('script')
    <script>
        $(function(){
            $('#cash_payment').click(function(){
                var newDiv = document.createElement('div');
                newDiv.innerHTML = `
                <section class="input-group input-group-sm">
                    <input type="text" name="cash_receiver" class="form-control" form="payment_submit" placeholder="نام و نام خانوادگی دریافت کننده" >
                </section>
                `;
                document.getElementsByClassName('content-wrapper')[1].appendChild(newDiv)
            })
        })
    </script>
@endsection