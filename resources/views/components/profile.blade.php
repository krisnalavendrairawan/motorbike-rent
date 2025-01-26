<li class="nav-item navbar-dropdown dropdown-user dropdown profile position-relative" style="z-index: 1050;">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
            <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end position-absolute" style="z-index: 1050;">
        <li>
            <a class="dropdown-item" href="#">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-online">
                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                class="w-px-40 h-auto rounded-circle" />
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                        <small class="text-muted">{{ Auth::user()->roles->first()->name ?? 'User' }}</small>
                    </div>
                </div>
            </a>
            <div class="menu-toggle-close d-block d-xl-none">
                <a href="javascript:void(0)" class="layout-menu-toggle menu-link text-large">
                    <i class="bx bx-x"></i>
                </a>
            </div>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <a class="dropdown-item" href="#">
                <i class="bx bx-user me-2"></i>
                <span class="align-middle">My Profile</span>
            </a>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bx bx-power-off me-2"></i>
                <span class="align-middle">Log Out</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="post" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</li>

@push('styles')
    <style>
        .profile .dropdown-menu {
            position: absolute;
            z-index: 1050;
            margin-top: 0.125rem;
        }

        .profile.show {
            position: relative;
            z-index: 1051;
        }
    </style>
@endpush
