<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="#hero">
            <span class="brand-text fs-3">Motorin<span class="text-warning">.</span></span>
        </a>

        <div class="d-flex align-items-center">
            @auth
                <div class="d-flex d-lg-none align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle d-flex align-items-center p-0" type="button"
                            id="profileDropdownMobile" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth()->user()->picture ? asset('storage/' . auth()->user()->picture) : asset('assets/img/avatars/1.png') }}"
                                alt="Profile" class="rounded-circle" width="32" height="32">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0"
                            aria-labelledby="profileDropdownMobile">
                            <li><a class="dropdown-item" href="{{ route('customer.profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('transaction.index') }}">My Bookings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('customer.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endauth

            <button class="navbar-toggler ms-2 border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>


        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#hero">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('catalog.index') ? 'active' : '' }}"
                        href="{{ route('catalog.index') }}">Katalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#features">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#facilities">Fasilitas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#requirements">Persyaratan</a>
                </li>
            </ul>

            <div class="navbar-auth d-flex align-items-center">
                @auth
                    <div class="dropdown d-none d-lg-block">
                        <button class="btn btn-link dropdown-toggle d-flex align-items-center" type="button"
                            id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth()->user()->picture ? asset('storage/' . auth()->user()->picture) : asset('assets/img/avatars/1.png') }}"
                                alt="Profile" class="rounded-circle me-2" width="32" height="32">
                            <span>{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu shadow-sm border-0" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="{{ route('customer.profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('transaction.index') }}">My Bookings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('customer.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('customer.login.index') }}"
                        class="btn btn-outline-dark btn-sm me-2 d-flex align-items-center">
                        {{ svg('entypo-login', ['width' => 18, 'height' => 18]) }}
                        <span class="ms-1 d-none d-md-inline">Login</span>
                    </a>
                    <a href="{{ route('customer.register.create') }}"
                        class="btn btn-dark btn-sm me-2 d-flex align-items-center">
                        {{ svg('heroicon-o-pencil', ['width' => 18, 'height' => 18]) }}
                        <span class="ms-1 d-none d-md-inline">Register</span>
                    </a>
                    <a href="/login" class="btn btn-outline-primary btn-sm d-flex align-items-center">
                        {{ svg('heroicon-o-shield-check', ['width' => 18, 'height' => 18]) }}
                        <span class="ms-1 d-none d-md-inline">Staff/Admin</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@push('styles')
    <style>
        /* Navbar Styling */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            padding: 15px 0;
        }

        .navbar.scrolled {
            padding: 10px 0;
            background-color: rgba(255, 255, 255, 0.98);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }


        .nav-link {
            font-weight: 500;
            padding: 8px 16px;
            position: relative;
            transition: all 0.3s ease;
            color: #333;
        }

        .nav-link:before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: #FFB800;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover:before,
        .nav-link.active:before {
            width: 70%;
        }

        .nav-link.active {
            color: #000;
            font-weight: 600;
        }

        .navbar-toggler {
            padding: 4px 8px;
            transition: all 0.3s ease;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }


        .dropdown-menu {
            border-radius: 10px;
            overflow: hidden;
        }

        .dropdown-item {
            padding: 8px 16px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .brand-text {
            font-size: 1.75rem !important;
            font-weight: 700;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #333 0%, #000 100%);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            position: relative;
            transition: all 0.3s ease;
        }

        .brand-text .text-warning {
            color: #FFB800 !important;
            font-weight: 800;
            font-size: 2rem;
            display: inline-block;
            transform: translateY(2px);
        }

        .brand-text:hover {
            transform: scale(1.05);
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        @media (min-width: 992px) {
            .brand-text {
                font-size: 2rem !important;
            }

            .brand-text .text-warning {
                font-size: 2.25rem;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .navbar-collapse {
                background-color: white;
                border-radius: 10px;
                padding: 20px;
                margin-top: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .navbar-nav {
                margin-bottom: 15px;
            }

            .nav-link:before {
                left: 0;
                transform: none;
            }

            .nav-link:hover:before,
            .nav-link.active:before {
                width: 30px;
            }
        }


        /* Button animations */
        .btn-outline-dark,
        .btn-dark,
        .btn-outline-primary {
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-outline-dark:hover,
        .btn-outline-primary:hover {
            transform: translateY(-2px);
        }

        .btn-dark:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Staff/Admin button specific styling */
        .btn-outline-primary {
            border-color: #4361ee;
            color: #4361ee;
        }

        .btn-outline-primary:hover {
            background-color: #4361ee;
            color: white;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize GSAP
            gsap.registerPlugin(ScrollTrigger);

            const navbar = document.querySelector('.navbar');
            const navItems = document.querySelectorAll('.nav-item');
            const brandText = document.querySelector('.brand-text');

            const buttonSelectors = '.btn-book, .btn-outline-dark, .btn-dark, .btn-outline-primary';
            const buttons = document.querySelectorAll(buttonSelectors);

            const tl = gsap.timeline({
                defaults: {
                    duration: 0.8,
                    ease: 'power3.out'
                }
            });

            if (brandText) {
                gsap.set(brandText, {
                    opacity: 0,
                    y: -20
                });
            }

            if (navItems.length > 0) {
                gsap.set(navItems, {
                    opacity: 0,
                    y: -20
                });
            }

            if (buttons.length > 0) {
                gsap.set(buttons, {
                    opacity: 0,
                    y: -20
                });
            }

            tl.from('.navbar', {
                y: -100,
                opacity: 0,
                duration: 1
            });

            if (brandText) {
                tl.to(brandText, {
                    opacity: 1,
                    y: 0,
                    duration: 0.6
                });
            }

            if (navItems.length > 0) {
                tl.to(navItems, {
                    opacity: 1,
                    y: 0,
                    stagger: 0.1,
                    duration: 0.6
                }, '-=0.3');
            }

            if (buttons.length > 0) {
                tl.to(buttons, {
                    opacity: 1,
                    y: 0,
                    stagger: 0.1,
                    duration: 0.6,
                    onComplete: () => {
                        buttons.forEach(button => {
                            button.classList.add('animated');
                        });
                    }
                }, '-=0.3');
            }

            let lastScrollTop = 0;
            const scrollThreshold = 80;

            window.addEventListener('scroll', () => {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (Math.abs(scrollTop - lastScrollTop) > 10) {
                    if (scrollTop > scrollThreshold) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                    lastScrollTop = scrollTop;
                }
            });

            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                link.addEventListener('mouseenter', () => {
                    if (!link.classList.contains('active')) {
                        gsap.to(link, {
                            color: '#000',
                            duration: 0.3,
                            ease: 'power2.out'
                        });
                    }
                });

                link.addEventListener('mouseleave', () => {
                    if (!link.classList.contains('active')) {
                        gsap.to(link, {
                            color: '#333',
                            duration: 0.3,
                            ease: 'power2.out'
                        });
                    }
                });
            });

            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');

            if (navbarToggler && navbarCollapse) {
                navbarToggler.addEventListener('click', () => {
                    if (!navbarCollapse.classList.contains('show')) {
                        const navItems = document.querySelectorAll('.navbar-collapse .nav-item');
                        if (navItems.length > 0) {
                            gsap.from(navItems, {
                                y: -20,
                                opacity: 0,
                                stagger: 0.1,
                                duration: 0.4,
                                ease: 'power2.out'
                            });
                        }
                    }
                });
            }

            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');

                    if (href && href.startsWith('#') && href !== '#') {
                        e.preventDefault();

                        const targetSection = document.querySelector(href);
                        if (targetSection) {
                            const navHeight = document.querySelector('.navbar').offsetHeight;
                            const targetPosition = targetSection.getBoundingClientRect().top +
                                window.pageYOffset - navHeight;

                            gsap.to(window, {
                                duration: 1,
                                scrollTo: {
                                    y: targetPosition,
                                    autoKill: true
                                },
                                ease: 'power3.inOut'
                            });

                            if (navbarCollapse && navbarCollapse.classList.contains('show') &&
                                navbarToggler) {
                                navbarToggler.click();
                            }

                            document.querySelectorAll('.nav-link').forEach(navLink => {
                                navLink.classList.remove('active');
                            });
                            this.classList.add('active');
                        }
                    }
                });
            });

            let isScrolling;
            window.addEventListener('scroll', () => {
                window.clearTimeout(isScrolling);

                isScrolling = setTimeout(() => {
                    const sections = ['hero', 'requirements', 'facilities', 'features'];
                    const navHeight = document.querySelector('.navbar').offsetHeight;

                    // Find current section
                    let currentSection = '';
                    let minDistance = Infinity;

                    sections.forEach(sectionId => {
                        const section = document.getElementById(sectionId);
                        if (section) {
                            const rect = section.getBoundingClientRect();
                            const distance = Math.abs(rect.top - navHeight);

                            if (distance < minDistance) {
                                minDistance = distance;
                                currentSection = sectionId;
                            }
                        }
                    });

                    if (currentSection) {
                        document.querySelectorAll('.nav-link').forEach(link => {
                            link.classList.remove('active');
                            const href = link.getAttribute('href');
                            if (href === `#${currentSection}`) {
                                link.classList.add('active');
                            }
                        });
                    }
                }, 100);
            });

            setTimeout(() => {
                const scrollEvent = new Event('scroll');
                window.dispatchEvent(scrollEvent);
            }, 500);
        });
    </script>
@endpush
