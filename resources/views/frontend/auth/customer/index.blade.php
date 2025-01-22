<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title') - Your App Name</title>
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/sweetalert/sweetalert2.min.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    @stack('styles')
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
        const month_mmmm = JSON.parse('{!! json_encode([
            __('label.january'),
            __('label.february'),
            __('label.march'),
            __('label.april'),
            __('label.may'),
            __('label.june'),
            __('label.july'),
            __('label.august'),
            __('label.september'),
            __('label.october'),
            __('label.november'),
            __('label.december'),
        ]) !!}')
        const month_mmm = JSON.parse('{!! json_encode([
            __('label.jan'),
            __('label.feb'),
            __('label.mar'),
            __('label.apr'),
            __('label.may'),
            __('label.jun'),
            __('label.jul'),
            __('label.aug'),
            __('label.sep'),
            __('label.oct'),
            __('label.nov'),
            __('label.dec'),
        ]) !!}')
        const day_dddd = JSON.parse('{!! json_encode([
            __('label.monday'),
            __('label.tuesday'),
            __('label.wednesday'),
            __('label.thursday'),
            __('label.friday'),
            __('label.saturday'),
            __('label.sunday'),
        ]) !!}')
        const day_ddd = JSON.parse('{!! json_encode([
            __('label.mon'),
            __('label.tue'),
            __('label.wed'),
            __('label.thu'),
            __('label.fri'),
            __('label.sat'),
            __('label.sun'),
        ]) !!}')
    </script>
    <!-- Scripts -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Content -->
    <div class="container-xxl">
        @yield('content')
    </div>
    <!-- / Content -->

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('vendors/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

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
