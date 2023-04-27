@extends('customer.layouts.master-one-col')

@section('head-tag')
    <title>آدرس</title>
@endsection
@section('content')
    <section class="mb-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>تکمیل اطلاعات ارسال کالا (آدرس گیرنده، مشخصات گیرنده، نحوه ارسال) </span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <section class="row mt-4">
                        <section class="col-md-9">
                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                            انتخاب آدرس و مشخصات گیرنده
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>

                                <section class="address-alert alert alert-primary d-flex align-items-center p-2"
                                    role="alert">
                                    <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                    <secrion>
                                        پس از ایجاد آدرس، آدرس را انتخاب کنید.
                                    </secrion>
                                </section>


                                <section class="address-select">

                                    @foreach ($addresses as $address)
                                        <input type="radio" name="address_id" form="send" value="{{ $address->id }}"
                                            id="{{ $address->id }}" />
                                        <!--checked="checked"-->
                                            <label for="{{ $address->id }}" class="address-wrapper mb-2 p-2">
                                                <section class="mb-2">
                                                    <i class="fa fa-map-marker-alt mx-1"></i>
                                                    {{ $address->address ?? '-' }}
                                                </section>
                                                <section class="mb-2">
                                                    <i class="fa fa-user-tag mx-1"></i>
                                                    گیرنده : {{ $address->recipient_first_name ?? '-' }}
                                                    {{ $address->recipient_last_name ?? '-' }}
                                                </section>
                                                <section class="mb-2">
                                                    <i class="fa fa-mobile-alt mx-1"></i>
                                                    موبایل گیرنده : {{ $address->mobile ?? '-' }}
                                                </section>
                                                <a data-bs-toggle="modal"
                                                    data-bs-target="#edit-address-{{ $address->id }}"><i
                                                        class="fa fa-edit"></i> ویرایش آدرس</a>
                                                <span class="address-selected">کالاها به این آدرس ارسال می شوند</span>
                                            </label>

                                            <!-- start add address Modal -->
                                            <section class="modal fade" id="edit-address-{{ $address->id }}" tabindex="-1"
                                                aria-labelledby="add-address-label" aria-hidden="true">
                                                <section class="modal-dialog">
                                                    <section class="modal-content">
                                                        <section class="modal-header">
                                                            <h5 class="modal-title" id="add-address-label"><i
                                                                    class="fa fa-plus"></i> ایجاد آدرس جدید</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </section>
                                                        <section class="modal-body">
                                                            <form
                                                                action='{{ route('home.sales-proccess.update-address', $address) }}'
                                                                method="POST" class="row">
                                                                @csrf
                                                                <section class="col-6 mb-2">
                                                                    <label for="province"
                                                                        class="form-label mb-1">استان</label>
                                                                    <select name="province_id"
                                                                        class="form-select form-select-sm"
                                                                        id="province-{{ $address->id }}">

                                                                        <option selected>استان را انتخاب کنید</option>
                                                                        @foreach ($provinces as $province)
                                                                            <option value="{{ $province->id }}"
                                                                                {{ $address->province_id == $province->id ? 'selected' : '' }}
                                                                                data-url="{{ route('home.sales-proccess.get-cities', $province->id) }}">
                                                                                {{ $province->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </section>

                                                                <section class="col-6 mb-2">
                                                                    <label for="city"
                                                                        class="form-label mb-1">شهر</label>
                                                                    <select name="city_id"
                                                                        class="form-select form-select-sm"
                                                                        id="city-{{ $address->id }}">
                                                                        <option selected>شهر را انتخاب کنید</option>
                                                                    </select>
                                                                </section>
                                                                <section class="col-12 mb-2">
                                                                    <label for="address"
                                                                        class="form-label mb-1">نشانی</label>
                                                                    <textarea name="address" type="text" class="form-control form-control-sm" id="address">{{ $address->address }}</textarea>
                                                                </section>

                                                                <section class="col-6 mb-2">
                                                                    <label for="postal_code" class="form-label mb-1">کد
                                                                        پستی</label>
                                                                    <input name="postal_code" type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="postal_code"
                                                                        value="{{ $address->postal_code }}"
                                                                        placeholder="کد پستی">
                                                                </section>

                                                                <section class="col-3 mb-2">
                                                                    <label for="no"
                                                                        class="form-label mb-1">پلاک</label>
                                                                    <input name="no" type="text"
                                                                        class="form-control form-control-sm" id="no"
                                                                        placeholder="پلاک" value="{{ $address->no }}">
                                                                </section>

                                                                <section class="col-3 mb-2">
                                                                    <label for="unit"
                                                                        class="form-label mb-1">واحد</label>
                                                                    <input name="unit" type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="unit" placeholder="واحد"
                                                                        value="{{ $address->unit }}">
                                                                </section>

                                                                <section class="border-bottom mt-2 mb-3"></section>

                                                                <section class="col-12 mb-2">
                                                                    <section class="form-check">
                                                                        <input name="receiver" class="form-check-input"
                                                                            type="checkbox" id="receiver"
                                                                            @if ($address->recipient_first_name) checked @endif>
                                                                        <label class="form-check-label" for="receiver">
                                                                            گیرنده سفارش خودم نیستم
                                                                        </label>
                                                                    </section>
                                                                </section>

                                                                <section class="col-6 mb-2">
                                                                    <label for="first_name" class="form-label mb-1">نام
                                                                        گیرنده</label>
                                                                    <input name='recipient_first_name' type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="first_name" placeholder="نام گیرنده"
                                                                        value="{{ $address->recipient_first_name }}">
                                                                </section>

                                                                <section class="col-6 mb-2">
                                                                    <label for="last_name" class="form-label mb-1">نام
                                                                        خانوادگی گیرنده</label>
                                                                    <input name='recipient_last_name' type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="last_name" placeholder="نام خانوادگی گیرنده"
                                                                        value="{{ $address->recipient_last_name }}">
                                                                </section>

                                                                <section class="col-6 mb-2">
                                                                    <label for="mobile" class="form-label mb-1">شماره
                                                                        موبایل</label>
                                                                    <input name="mobile" type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="mobile" placeholder="شماره موبایل"
                                                                        value="{{ $address->mobile }}">
                                                                </section>


                                                        </section>
                                                        <section class="modal-footer py-1">
                                                            <button type="submit" class="btn btn-sm btn-primary">ثبت
                                                                آدرس</button>
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                data-bs-dismiss="modal">بستن</button>
                                                        </section>
                                                        </form>
                                                    </section>
                                                </section>
                                            </section>
                                            <!-- end add address Modal -->
                                    @endforeach


                                    <section class="address-add-wrapper">

                                        <button class="address-add-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#add-address"><i class="fa fa-plus"></i> ایجاد آدرس
                                            جدید</button>
                                        <!-- start add address Modal -->
                                        <section class="modal fade" id="add-address" tabindex="-1"
                                            aria-labelledby="add-address-label" aria-hidden="true">
                                            <section class="modal-dialog">
                                                <section class="modal-content">
                                                    <section class="modal-header">
                                                        <h5 class="modal-title" id="add-address-label"><i
                                                                class="fa fa-plus"></i> ایجاد آدرس جدید</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </section>
                                                    <section class="modal-body">
                                                        <form action='{{ route('home.sales-proccess.add-address') }}'
                                                            method="POST" class="row">
                                                            @csrf
                                                            <section class="col-6 mb-2">
                                                                <label for="province"
                                                                    class="form-label mb-1">استان</label>
                                                                <select name="province_id"
                                                                    class="form-select form-select-sm" id="province">

                                                                    <option selected>استان را انتخاب کنید</option>
                                                                    @foreach ($provinces as $province)
                                                                        <option value="{{ $province->id }}"
                                                                            data-url="{{ route('home.sales-proccess.get-cities', $province->id) }}">
                                                                            {{ $province->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="city" class="form-label mb-1">شهر</label>
                                                                <select name="city_id" class="form-select form-select-sm"
                                                                    id="city">
                                                                    <option selected>استان را انتخاب کنید</option>
                                                                </select>
                                                            </section>
                                                            <section class="col-12 mb-2">
                                                                <label for="address"
                                                                    class="form-label mb-1">نشانی</label>
                                                                <textarea name="address" type="text" class="form-control form-control-sm" id="address"></textarea>
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="postal_code" class="form-label mb-1">کد
                                                                    پستی</label>
                                                                <input name="postal_code" type="text"
                                                                    class="form-control form-control-sm" id="postal_code"
                                                                    placeholder="کد پستی">
                                                            </section>

                                                            <section class="col-3 mb-2">
                                                                <label for="no" class="form-label mb-1">پلاک</label>
                                                                <input name="no" type="text"
                                                                    class="form-control form-control-sm" id="no"
                                                                    placeholder="پلاک">
                                                            </section>

                                                            <section class="col-3 mb-2">
                                                                <label for="unit" class="form-label mb-1">واحد</label>
                                                                <input name="unit" type="text"
                                                                    class="form-control form-control-sm" id="unit"
                                                                    placeholder="واحد">
                                                            </section>

                                                            <section class="border-bottom mt-2 mb-3"></section>

                                                            <section class="col-12 mb-2">
                                                                <section class="form-check">
                                                                    <input name="receiver" class="form-check-input"
                                                                        type="checkbox" id="receiver">
                                                                    <label class="form-check-label" for="receiver">
                                                                        گیرنده سفارش خودم نیستم
                                                                    </label>
                                                                </section>
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="first_name" class="form-label mb-1">نام
                                                                    گیرنده</label>
                                                                <input name='recipient_first_name' type="text"
                                                                    class="form-control form-control-sm" id="first_name"
                                                                    placeholder="نام گیرنده">
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="last_name" class="form-label mb-1">نام
                                                                    خانوادگی گیرنده</label>
                                                                <input name='recipient_last_name' type="text"
                                                                    class="form-control form-control-sm" id="last_name"
                                                                    placeholder="نام خانوادگی گیرنده">
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="mobile" class="form-label mb-1">شماره
                                                                    موبایل</label>
                                                                <input name="mobile" type="text"
                                                                    class="form-control form-control-sm" id="mobile"
                                                                    placeholder="شماره موبایل">
                                                            </section>


                                                    </section>
                                                    <section class="modal-footer py-1">
                                                        <button type="submit" class="btn btn-sm btn-primary">ثبت
                                                            آدرس</button>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            data-bs-dismiss="modal">بستن</button>
                                                    </section>
                                                    </form>
                                                </section>
                                            </section>
                                        </section>
                                        <!-- end add address Modal -->
                                    </section>

                                </section>
                            </section>


                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                            انتخاب نحوه ارسال
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>

                                <section class="delivery-select ">

                                    <section class="address-alert alert alert-primary d-flex align-items-center p-2"
                                        role="alert">
                                        <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                        <secrion>
                                            نحوه ارسال کالا را انتخاب کنید. هنگام انتخاب لطفا مدت زمان ارسال را در نظر
                                            بگیرید.
                                        </secrion>
                                    </section>
                                    @foreach ($deliveries as $delivery)
                                        <input type="radio" form="send" name="delivery_id" value="{{ $delivery->id }}"
                                            id="d-{{ $delivery->id }}" />
                                        <label for="d-{{ $delivery->id }}"
                                            class="col-12 col-md-4 delivery-wrapper mb-2 pt-2">
                                            <section class="mb-2">
                                                <i class="fa fa-shipping-fast mx-1"></i>
                                                {{ $delivery->name }}
                                            </section>
                                            <section class="mb-2">
                                                <i class="fa fa-calendar-alt mx-1"></i>
                                                تامین کالا از {{ $delivery->delivery_time }}
                                                {{ $delivery->delivery_time_unit }} کاری آینده
                                            </section>
                                        </label>
                                    @endforeach

                                </section>
                            </section>


                            @php
                                $totalProductPrice = 0;
                                $totalDiscount = 0;
                            @endphp

                            @foreach ($cartItems as $cartItem)
                                @php
                                    $totalProductPrice += $cartItem->cartItemProductPrice() * $cartItem->number;
                                    $totalDiscount += $cartItem->cartItemProductDiscount() * $cartItem->number;
                                @endphp
                            @endforeach

                        </section>
                        <section class="col-md-3">
                            <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">قیمت کالاها ({{ $cartItems->count() }})</p>
                                    <p class="text-muted">{{ priceFormat($totalProductPrice) }} تومان</p>
                                </section>

                                @if ($totalDiscount > 0)

                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">تخفیف کالاها</p>
                                    <p class="text-danger fw-bolder">{{ priceFormat($totalDiscount) }} تومان</p>
                                </section>

                                @endif

                                <section class="border-bottom mb-3"></section>

                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">جمع سبد خرید</p>
                                    <p class="fw-bolder">{{ priceFormat($totalProductPrice) }} تومان</p>
                                </section>

                                {{-- <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">هزینه ارسال</p>
                                    <p class="text-warning">54,000 تومان</p>
                                </section> --}}

                                <p class="my-3">
                                    <i class="fa fa-info-circle me-1"></i> کاربر گرامی کالاها بر اساس نوع ارسالی که انتخاب
                                    می کنید در مدت زمان ذکر شده ارسال می شود.
                                </p>

                                <section class="border-bottom mb-3"></section>

                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">مبلغ قابل پرداخت</p>
                                    <p class="fw-bold">{{priceFormat($totalProductPrice - $totalDiscount)}}</p>
                                </section>

                                    <form action="{{route('home.sales-proccess.choose-address-delivery')}}" id="send" method="post">
                                        @csrf
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
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#province').change(function() {
                var element = $('#province option:selected');
                var url = element.attr('data-url');

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {
                        if (response.status) {
                            let cities = response.cities;
                            $('#city').empty();
                            cities.map((city) => {
                                $('#city').append($('<option/>').val(city.id).text(city
                                    .name))
                            })
                        } else {
                            errorToast('خطا پیش آمده است')
                        }
                    },
                    error: function() {
                        errorToast('خطا پیش آمده است')
                    }
                })
            });

            // edit
            var addresses = {!! auth()->user()->addresses !!}
            addresses.map(function(address) {
                var id = address.id;
                var target = `#province-${id}`;
                var selected = `${target} option:selected`
                $(target).change(function() {
                    var element = $(selected);
                    var url = element.attr('data-url');

                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(response) {
                            if (response.status) {
                                let cities = response.cities;
                                $(`#city-${id}`).empty();
                                cities.map((city) => {
                                    $(`#city-${id}`).append($('<option/>').val(
                                        city.id).text(city
                                        .name))
                                })
                            } else {
                                errorToast('خطا پیش آمده است')
                            }
                        },
                        error: function() {
                            errorToast('خطا پیش آمده است')
                        }
                    })
                })
            })
        });
    </script>
@endsection
