<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">

    <!-- Critical CSS -->
    <style>
        @font-face {
            font-family: 'Open Sans';
            src: url('./assets/fonts/OpenSans-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'Open Sans', sans-serif;
        }
    </style>

    <!-- Core CSS - Load these first -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">

    <!-- Deferred CSS - Load these later -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/sweetalert/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />

    <!-- Critical Scripts - Load these first -->
    <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('assets/js/ScrollToPlugin.min.js') }}"></script>

    <script>
        const label_search = "{{ __('label.search') }}"
        const label_show = "{{ __('label.show') }}"
        const label_edit = "{{ __('label.edit') }}"
        const label_delete = "{{ __('label.delete') }}"
        const label_success = "{{ strtoupper(__('label.success')) }}"
        const label_failed = "{{ strtoupper(__('label.failed')) }}"
        const label_info = "{{ strtoupper(__('label.info')) }}"
        const label_confirmation = "{{ strtoupper(__('label.confirmation')) }}"
        const label_yes = "{{ strtoupper(__('label.yes')) }}"
        const label_cancel = "{{ strtoupper(__('label.cancel')) }}"
        const label_choose = "{{ __('label.choose') }}"
        const label_nodata = "{{ __('string.no_data_available') }}"
        const string_confirm_delete = "{{ __('string.confirm_delete') }}"
    </script>

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>

    @stack('styles')
</head>

<body>
    @include('frontend.landing.navbar')
    @include('frontend.landing.hero')
    @include('frontend.landing.stats')
    @include('frontend.landing.features')
    {{-- @include('frontend.landing.about') --}}
    @include('frontend.landing.facilities')
    @include('frontend.landing.requirements')
    @include('frontend.landing.vehicles')
    @include('frontend.landing.testimonials')
    @include('frontend.landing.faq')
    @include('frontend.landing.contact')
    @include('frontend.landing.footer')

    <!-- Deferred Scripts - Load these later -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>

    <!-- Plugin scripts -->
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('vendors/sweetalert/sweetalert2.all.min.js') }}"></script>



    <!-- Menu related scripts -->
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>

    <!-- Charts and analytics -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- App specific scripts -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    @if (session()->has('success'))
        <script>
            $(document).ready(function() {
                setNotifSuccess("{{ session()->get('success') }}", false)
            })
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            $(document).ready(function() {
                setNotifFail("{{ session()->get('error') }}")
            })
        </script>
    @endif

    @stack('scripts')
</body>

</html>
