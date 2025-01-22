<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ Config::get('app.name') }}</title>

    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/sweetalert/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/util.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/colorlib.css') }}">

    @stack('styles')

    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script>
        const label_search = "{{ __('label.search') }}"
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
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="d-block d-sm-none">
                    <img src="{{ asset('assets/images/auth/stats.jpg') }}" class="img-fluid" />
                </div>

                @yield('content')

                <div class="login100-more" style="background-image: url('{{ asset('assets/img/auth/stats.jpg') }}');">
                </div>
            </div>
        </div>

        <script src={{ asset('vendors/js/vendor.bundle.base.js') }}></script>
        <script src="{{ asset('vendors/sweetalert/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>

        @if (session()->has('error'))
            <script>
                $(document).ready(function() {
                    setNotifInfo("{{ session()->get('error') }}")
                })
            </script>
        @endif

        @stack('scripts')
</body>

</html>
