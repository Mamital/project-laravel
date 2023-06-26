@extends('customer.layouts.master-simple')
@section('head-tag')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {!! htmlScriptTagJsApi() !!}
@endsection
@section('content')
    <section class="vh-100 d-flex justify-content-center align-items-center pb-5">
        <form action="{{ route('home.profile.my-email.confirm', ['token' => $token]) }}" method="POST">
            @csrf
            <section class="login-wrapper mb-5">
                <section class="login-logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('customer-assets/images/logo/4.png') }}"
                            alt="logo"></a>
                </section>

                <section class="login-title">تایید ایمیل</section>
                <section class="login-info">کد ارسال شده به ایمیل {{ $email }} را وارد کنید</section>
                <section class="login-input-text">
                    <input class="my-3" type="text" name="otp" value="{{ old('otp') }}">
                    @error('otp')
                        <span class="alert_required text-danger p-1 rounded" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                </section>
                <section class="login-btn d-grid g-2"><button class="btn btn-danger" type="submit">تایید</button>
                </section>
                <a class="text-decoration-none" href="{{ route('home.profile.my-email.index') }}">ایمیل را اشتباهی وارد
                    کردید؟</a>
            </section>
    </section>
    </form>
    </section>
@endsection
