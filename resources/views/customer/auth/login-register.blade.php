@extends('customer.layouts.master-simple')
@section('head-tag')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {!! htmlScriptTagJsApi() !!}
@endsection
@section('content')
    <section class="vh-100 d-flex justify-content-center align-items-center pb-5">
        <form action="{{ route('auth.customer.login-register') }}" method="POST">
            @csrf
            <section class="login-wrapper mb-5">
                <section class="login-logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('customer-assets/images/logo/4.png') }}"
                            alt="logo"></a>
                </section>

                <section class="login-title">ورود / ثبت نام</section>
                <section class="login-info">شماره موبایل یا پست الکترونیک خود را وارد کنید</section>
                <section class="login-input-text">
                    <input class="my-3" type="text" name="id" value="{{ old('id') }}">
                    @error('id')
                        <span class="alert_required text-danger p-1 rounded" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                </section>
                <section class="login-btn d-grid g-2"><button class="btn btn-danger" type="submit">ورود به آمازون</button>
                </section>
                <section class="login-terms-and-conditions"><a href="#">شرایط و قوانین</a> را خوانده ام و پذیرفته ام
                </section>
            </section>
        </form>
    </section>
@endsection
