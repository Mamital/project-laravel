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

    <section class="container-xxl body-container">
        @yield('customer.layouts.sidebar')
    </section>

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
