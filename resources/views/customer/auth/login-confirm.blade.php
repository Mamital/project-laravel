@extends('customer.layouts.master-simple')

@section('head-tag')
    <style>
        #resent_otp {
            font-size: 11rem
        }
    </style>
@endsection
@section('content')
    <section class="vh-100 d-flex justify-content-center align-items-center pb-5">
        <form action="{{ route('auth.customer.login-confirm', $token) }}" method="POST">
            @csrf
            <section class="login-wrapper mb-5">
                <section class="login-logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('customer-assets/images/logo/4.png') }}" alt="logo"></a>
                </section>
                <section class="login-title">
                    <a href="{{ route('auth.customer.login-register-form') }}"><i class="fa fa-arrow-right"> بازگشت</i></a>
                </section>
                <section class="login-title">کد تایید را وارد نمایید</section>
                <section class="login-info">
                    @if ($otp->type = 0)
                        کد یکبار مصرف به شماره {{ $otp->login_id }} ارسال گردید
                    @elseif ($otp->type = 1)
                        کد تاییدیه به ایمیل {{ $otp->login_id }} ارسال گردید
                    @endif
                </section>
                <section class="login-input-text">
                    <input class="my-3" type="text" name="otp" value="{{ old('otp') }}">
                    @error('otp')
                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                </section>
                <section class="login-btn d-grid g-2"><button class="btn btn-danger" type="submit">تایید</button></section>
                <section id="resend-otp" class="d-none">
                    <a href="{{route('auth.customer.login-resend-confirm', $token)}}" class="text-decoration-none text-primary">دریافت مجدد کد تایید</a>
                </section>
                <section class="login-info" id="timer"></section> 
            </section>
    </section>
    </form>
    </section>
@endsection

@section('script')
    @php
        $timer = ((new \Carbon\Carbon($otp->created_at))->addMinutes(5)->timestamp - \Carbon\Carbon::now()->timestamp) * 1000;
    @endphp

    <script>
        var countDownDate = new Date().getTime() + {{ $timer }};
        var timer = $('#timer');
        var resendOtp = $('#resend-otp');

        var x = setInterval(function() {

            var now = new Date().getTime();

            var distance = countDownDate - now;

            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (minutes == 0) {
                timer.html('ارسال مجدد کد تایید تا ' + seconds + ' ثانیه دیگر ')
            } else {
                timer.html('ارسال مجدد کد تایید تا ' + minutes + ' دقیقه و ' + seconds + ' ثانیه دیگر ');
            }
            if (distance < 0) {
                clearInterval(x);
                timer.addClass('d-none');
                resendOtp.removeClass('d-none');
            }

        }, 1000)
    </script>
@endsection
