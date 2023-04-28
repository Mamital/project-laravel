<!doctype html>
<html lang="fa" dir="rtl">

<head>
    @include('customer.layouts.head-tag')
    @yield('head-tag')
</head>

<body>


    <!-- start header -->
    @include('customer.layouts.header')
    <!-- end header -->
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                 @if (session('alert-success'))
                        <div class="alert alert-success">
                            {{session('alert-success')}}
                        </div>
                    @elseif (session('alert-error'))
                        <div class="alert alert-danger">
                            {{session('alert-error')}}
                        </div>
                    @endif
                @yield('customer.layouts.sidebar')

                @yield('content')

            </section>
        </section>
    </section>
    <!-- end body -->


    <!-- start footer -->
    @include('customer.layouts.footer')
    <!-- end footer -->



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    @include('customer.layouts.script')
    @yield('script')

    <section class="toast-wrapper flex-row-reverse">
        @include('admin.alerts.toast.success')
        @include('admin.alerts.toast.error')
    </section>
</body>

</html>
