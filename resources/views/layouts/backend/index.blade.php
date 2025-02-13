<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ Config::get('app.name') }}</title>

    <!-- Favicon -->

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">



    <!-- Core CSS - Load these first -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
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



    @stack('styles')
    <!-- Page CSS -->

    <!-- Helpers -->

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
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('layouts.backend.sidebar')

            <div class="layout-page">
                {{-- @include('layouts.backend.navbar') --}}

                <div class="main-panel">
                    <div class="content-wrapper mx-3">
                        <!-- Add header section here -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div
                                    class="page-title-box d-flex align-items-center justify-content-between mb-4 text-white bg-primary">
                                    <div>
                                        <div
                                            class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                                            <a class="nav-item nav-link px-0 me-xl-4 text-white"
                                                href="javascript:void(0)">
                                                <i class="bx bx-menu bx-sm"></i>
                                            </a>
                                        </div>
                                        <h4 class="mb-sm-0 font-size-18 text-white">@yield('title')</h4>
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb m-0 p-0 mt-2">
                                                <li class="breadcrumb-item"><a class="text-white"
                                                        href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                                @yield('breadcrumb')
                                            </ol>
                                        </nav>
                                    </div>
                                    @yield('page-action')
                                </div>
                            </div>
                        </div>
                        @yield('content')
                    </div>

                    @include('layouts.backend.footer')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>

    <!-- Plugin scripts -->
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('vendors/sweetalert/sweetalert2.all.min.js') }}"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}


    <!-- Menu related scripts -->
    <script src="{{ asset('assets/js/chart.js') }}"></script>
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
