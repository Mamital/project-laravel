<!doctype html>
<html lang="fa" dir="rtl">

<head>
    @include('customer.layouts.head-tag')
    @yield('head-tag')
</head>

<body dir="rtl">

    @include('admin.alerts.alert-section.success')

    <!-- start header -->
    @include('customer.layouts.header')
    <!-- end header -->



    <!-- start main one col -->
    <main id="main-body-one-col" class="main-body">

        @yield('content')

    </main>
    <!-- end main one col -->


    <!-- start footer -->
    @include('customer.layouts.footer')
    <!-- end footer -->



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    @include('customer.layouts.script')
    @yield('script')


</body>

</html>
