<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard.index') }}" class="app-brand-link">
            {{-- <img src="{{ asset('assets/img/avatars/motorinlogo.png') }}" alt="RapidRide Logo" class="logoMotorin"
                height="60" width="70" /> --}}

            <span class="app-brand-text demo menu-text fw-bolder ">Motorin</span>
            <a href="javascript:void(0)" class="layout-menu-toggle d-block d-xl-none">
                <i class='bx bxs-chevrons-left mt-2 ms-1'></i>
            </a>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
            <a href="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <!-- User -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">User</span>
        </li>
        <li class="menu-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
            <a href="{{ route('user.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user"></i>
                <div data-i18n="Analytics">{{ __('label.staff') }}</div>
            </a>
        </li>
        <!-- Customer -->
        <li class="menu-item {{ request()->routeIs('customer.*') ? 'active' : '' }}">
            <a href="{{ route('customer.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user"></i>
                <div data-i18n="Analytics">{{ __('label.customer') }}</div>
            </a>
        </li>

        {{-- Motor --}}

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Motor</div>
            </a>

            <ul class="menu-sub">

                <!-- Brand -->
                <li class="menu-item {{ request()->routeIs('brand.*') ? 'active' : '' }}">
                    <a href="{{ route('brand.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-captions"></i>
                        <div data-i18n="Analytics">{{ __('label.brand') }}</div>
                    </a>
                </li>
                <!-- Bike -->
                <li class="menu-item {{ request()->routeIs('bike.*') ? 'active' : '' }}">
                    <a href="{{ route('bike.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-vector"></i>
                        <div data-i18n="Analytics">{{ __('label.list_bike') }}</div>
                    </a>
                </li>
                <!-- Services -->
                <li class="menu-item {{ request()->routeIs('service.*') ? 'active' : '' }}">
                    <a href="{{ route('service.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-cog"></i>
                        <div data-i18n="Analytics">{{ __('label.service') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('label.rental') }}</span>
        </li>
        {{-- Rental --}}
        <li class="menu-item {{ request()->routeIs('rental.*') ? 'active' : '' }}">
            <a href="{{ route('rental.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-credit-card"></i>
                <div data-i18n="Analytics">{{ __('label.rental') }}</div>
            </a>
        </li>
        {{-- Penyewaan --}}
        <li class="menu-item {{ request()->routeIs('list.*') ? 'active' : '' }}">
            <a href="{{ route('list.rental') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-calendar-check"></i>
                <div data-i18n="Analytics">{{ __('label.list-rental') }}</div>
            </a>
        </li>
        {{-- Pengembalian --}}
        <li class="menu-item {{ request()->routeIs('return.*') ? 'active' : '' }}">
            <a href="{{ route('return.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-calendar-x"></i>
                <div data-i18n="Analytics">{{ __('label.return') }}</div>
            </a>
        </li>

        {{-- Motor --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('label.report') }}</span>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div data-i18n="Layouts">{{ __('label.report') }}</div>
            </a>

            <ul class="menu-sub">

                <!-- Weekly Report -->
                <li class="menu-item {{ request()->routeIs('weekly-report.*') ? 'active' : '' }}">
                    <a href="{{ route('weekly-report.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-calendar"></i>
                        <div data-i18n="Analytics">{{ __('label.weekly_report') }}</div>
                    </a>
                </li>
                <!-- Monthly Report -->
                <li class="menu-item {{ request()->routeIs('monthly-report.*') ? 'active' : '' }}">
                    <a href="{{ route('monthly-report.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-calendar"></i>
                        <div data-i18n="Analytics">{{ __('label.monthly_report') }}</div>
                    </a>
                </li>
                <!-- Bike -->
                <li class="menu-item {{ request()->routeIs('bike-report.*') ? 'active' : '' }}">
                    <a href="{{ route('bike-report') }}" class="menu-link">

                        <i class="menu-icon tf-icons bx bxs-bar-chart-square"></i>
                        <div data-i18n="Analytics">{{ __('label.bike_report') }}</div>
                    </a>
                </li>
                <!-- Services -->
                <li class="menu-item {{ request()->routeIs('yearly-report.*') ? 'active' : '' }}">
                    <a href="{{ route('yearly-report.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-calendar-star"></i>
                        <div data-i18n="Analytics">{{ __('label.yearly_report') }}</div>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
@push('styles')
    <style>
        .menu-toggle-close {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 1000;
        }

        .menu-toggle-close .menu-link {
            color: #697a8d;
            font-size: 1.5rem;
            padding: 0;
        }
    </style>
@endpush
