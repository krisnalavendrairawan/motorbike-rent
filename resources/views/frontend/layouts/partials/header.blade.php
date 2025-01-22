    <header class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(to right, #2c3e50, #3498db);">
        <div class="container py-2">

            <a href="{{ route('landing.index') }}" class="navbar-brand d-flex align-items-center">
                <i class='bx bx-home-alt fs-4 me-2 text-white'></i>
                <span class="text-white fw-semibold">Beranda</span>
            </a>
            <a href="{{ route('catalog.index') }}" class="navbar-brand d-flex align-items-center">
                <span class="text-white fw-semibold">Katalog</span>
            </a>
            <a href="{{ route('transaction.index') }}" class="navbar-brand d-flex align-items-center">
                <span class="text-white fw-semibold">Riwayat Transaksi</span>
            </a>

            <!-- User Menu -->
            <div class="ms-auto">
                <div class="dropdown">
                    @auth
                        <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="userDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false"
                            style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: white;">
                            <i class='bx bx-user-circle fs-5 me-2'></i>
                            <span>{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2" aria-labelledby="userDropdown"
                            style="background: white; border-radius: 10px;">
                            <li>
                                <a class="dropdown-item py-2 px-4 d-flex align-items-center" href="#"
                                    style="color: #2c3e50; transition: all 0.3s ease;">
                                    <i class='bx bx-user me-2 fs-5'></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider mx-2">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('customer.logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item py-2 px-4 d-flex align-items-center text-danger"
                                        style="transition: all 0.3s ease;">
                                        <i class='bx bx-log-out me-2 fs-5'></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @else
                        <a href="{{ route('customer.login.index') }}" class="btn d-flex align-items-center"
                            style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: white; transition: all 0.3s ease;">
                            <i class='bx bx-log-in-circle fs-5 me-2'></i>
                            <span>Login</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

