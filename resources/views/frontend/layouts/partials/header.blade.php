<header class="navbar navbar-expand-lg sticky-top shadow-sm bg-white">
    <div class="container">
        <!-- Brand with stylized text instead of logo -->
        <a href="{{ route('landing.index') }}" class="navbar-brand d-flex align-items-center">
            <span class="fw-bold motorin-text">MOTORIN</span>
        </a>
        
        <!-- Mobile toggle button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bx bx-menu fs-3"></i>
        </button>
        
        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item mx-lg-2">
                    <a href="{{ route('landing.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('landing.index') ? 'active fw-semibold' : '' }}">
                        <i class="bx bx-home me-2"></i>Beranda
                    </a>
                </li>
                <li class="nav-item mx-lg-2">
                    <a href="{{ route('catalog.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('catalog.index') ? 'active fw-semibold' : '' }}">
                        <i class="bx bx-category me-2"></i>Katalog
                    </a>
                </li>
                <li class="nav-item mx-lg-2">
                    <a href="{{ route('transaction.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('transaction.index') ? 'active fw-semibold' : '' }}">
                        <i class="bx bx-history me-2"></i>Riwayat Transaksi
                    </a>
                </li>
            </ul>
            
            <!-- User menu -->
            <div class="ms-lg-auto mt-3 mt-lg-0">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-primary rounded-pill d-flex align-items-center" type="button" 
                                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-user-circle fs-5 me-2"></i>
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            <i class="bx bx-chevron-down ms-2"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3" aria-labelledby="userDropdown">
                            <li class="px-3 py-2 text-muted small">Signed in as <strong>{{ Auth::user()->email }}</strong></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center" href="#">
                                    <i class="bx bx-user me-2"></i>Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center" href="#">
                                    <i class="bx bx-cog me-2"></i>Settings
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('customer.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 d-flex align-items-center text-danger">
                                        <i class="bx bx-log-out me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="d-flex">
                        <a href="{{ route('customer.login.index') }}" class="btn btn-outline-primary rounded-pill me-2 d-flex align-items-center">
                            <i class="bx bx-log-in me-md-2"></i>
                            <span class="d-none d-md-inline">Login</span>
                        </a>
                        <a href="{{ route('customer.register.create') }}" class="btn btn-primary rounded-pill d-flex align-items-center">
                            <i class="bx bx-user-plus me-md-2"></i>
                            <span class="d-none d-md-inline">Register</span>
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>

<style>
.motorin-text {
    font-family: 'Poppins', sans-serif;
    font-size: 1.8rem;
    letter-spacing: 1px;
    background: linear-gradient(45deg, #3498db, #2c3e50);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    position: relative;
    display: inline-block;
    padding-bottom: 2px;
}

.motorin-text::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(45deg, #3498db, #2c3e50);
    border-radius: 2px;
}

.navbar .nav-link {
    position: relative;
    padding: 0.5rem 0;
    margin: 0 0.5rem;
    transition: all 0.3s ease;
}

.navbar .nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background-color: #3498db;
    transition: width 0.3s ease;
}

.navbar .nav-link:hover::after,
.navbar .nav-link.active::after {
    width: 100%;
}

.dropdown-item:hover {
    background-color: rgba(52, 152, 219, 0.1);
}

.navbar-toggler:focus {
    box-shadow: none;
}

@media (max-width: 992px) {
    .navbar .nav-link {
        padding: 0.75rem 0;
    }
    
    .navbar .nav-link::after {
        display: none;
    }
    
    .navbar .nav-link.active,
    .navbar .nav-link:hover {
        color: #3498db;
        padding-left: 0.5rem;
    }
}
</style>