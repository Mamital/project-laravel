@extends('customer.layouts.master-simple')

@section('content')
    
    <section class="vh-100 d-flex justify-content-center align-items-center pb-5">
        <section class="login-wrapper mb-5">
            <section class="login-logo">
                <img src="{{asset('customer-assets/images/logo/4.png')}}" alt="">
            </section>
            <section class="login-title">ورود / ثبت نام</section>
            <section class="login-info">شماره موبایل یا پست الکترونیک خود را وارد کنید</section>
            <section class="login-input-text">
                <input type="text" >
            </section>
            <section class="login-btn d-grid g-2"><button class="btn btn-danger">ورود به آمازون</button></section>
            <section class="login-terms-and-conditions"><a href="#">شرایط و قوانین</a> را خوانده ام و پذیرفته ام</section>
        </section>
    </section>

@endsection