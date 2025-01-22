@push('styles')
    <style>

    </style>
@endpush

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        {{-- <a class="navbar-brand" href="#hero">
            <img src="{{ asset('assets/img/avatars/motorinlogo.png') }}" alt="Logo" width="100" height="50">
        </a> --}}

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
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

            <div class="d-flex align-items-center flex-wrap">
                <a href="{{ route('catalog.index') }}"
                    class="btn btn-book me-3 btn-outline-warning">{{ svg('heroicon-o-calendar-date-range', ['width' => 24, 'height' => 24]) }}
                    Book Now</a>
                {{-- <button class="btn btn-book me-3 btn-outline-warning">Book Now</button> --}}

                @auth
                    <!-- Show user profile when logged in -->
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle d-flex align-items-center" type="button"
                            id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->profile_photo_url ?? asset('assets/img/avatars/1.png') }}"
                                alt="Profile" class="rounded-circle me-2" width="32" height="32">
                            <span>{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">My Bookings</a></li>
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
                    <!-- Show login/register buttons when not logged in -->
                    <div class="navbar-auth">
                        <a href="{{ route('customer.login.index') }}"
                            class="btn btn-outline-primary">{{ svg('entypo-login', ['width' => 24, 'height' => 24]) }}
                            Login</a>
                        <a href="{{ route('customer.register.create') }}"
                            class="btn btn-primary">{{ svg('heroicon-o-pencil', ['width' => 24, 'height' => 24]) }}
                            Register</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize GSAP
            gsap.registerPlugin(ScrollTrigger);

            const navbar = document.querySelector('.navbar');
            const navItems = document.querySelectorAll('.nav-item');
            const buttons = document.querySelectorAll('.btn-book, .btn-login, .btn-register');

            // Initial animation timeline
            const tl = gsap.timeline({
                defaults: {
                    duration: 0.8,
                    ease: 'power3.out'
                }
            });

            // Set initial states
            gsap.set(['.navbar-brand', navItems, buttons], {
                opacity: 0,
                y: -20
            });

            // Animate navbar first
            tl.from('.navbar', {
                    y: -100,
                    opacity: 0,
                    duration: 1
                })
                .to('.navbar-brand', {
                    opacity: 1,
                    y: 0,
                    duration: 0.6
                })
                .to(navItems, {
                    opacity: 1,
                    y: 0,
                    stagger: 0.1,
                    duration: 0.6
                }, '-=0.3')
                .to(buttons, {
                    opacity: 1,
                    y: 0,
                    stagger: 0.1,
                    duration: 0.6,
                    onComplete: () => {
                        // Add animated class to buttons after animation
                        buttons.forEach(button => {
                            button.classList.add('animated');
                        });
                    }
                }, '-=0.3');

            // Scroll animation
            ScrollTrigger.create({
                start: 'top -80',
                onUpdate: (self) => {
                    if (self.direction === 1) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                }
            });

            // Hover animations
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                const hoverTl = gsap.timeline({
                    paused: true
                });

                hoverTl.to(link, {
                    color: '#3498db',
                    duration: 0.3,
                    ease: 'power2.out'
                });

                link.addEventListener('mouseenter', () => hoverTl.play());
                link.addEventListener('mouseleave', () => {
                    if (!link.classList.contains('active')) {
                        hoverTl.reverse();
                    }
                });
            });

            // Mobile menu animation
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');

            navbarToggler.addEventListener('click', () => {
                if (!navbarCollapse.classList.contains('show')) {
                    gsap.from('.navbar-collapse .nav-item', {
                        y: -20,
                        opacity: 0,
                        stagger: 0.1,
                        duration: 0.4,
                        ease: 'power2.out'
                    });
                }
            });

            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');

                    // Only handle links with hash
                    if (href && href.startsWith('#') && href !== '#') {
                        e.preventDefault();

                        const targetSection = document.querySelector(href);
                        if (targetSection) {
                            // Account for fixed navbar height
                            const navHeight = document.querySelector('.navbar').offsetHeight;
                            const targetPosition = targetSection.getBoundingClientRect().top +
                                window.pageYOffset - navHeight;

                            // Smooth scroll to section
                            window.scrollTo({
                                top: targetPosition,
                                behavior: 'smooth'
                            });

                            // Close mobile menu if open
                            const navbarCollapse = document.querySelector('.navbar-collapse');
                            if (navbarCollapse.classList.contains('show')) {
                                document.querySelector('.navbar-toggler').click();
                            }

                            // Update active state
                            document.querySelectorAll('.nav-link').forEach(navLink => {
                                navLink.classList.remove('active');
                            });
                            this.classList.add('active');
                        }
                    }
                });
            });

            // Update active section on scroll
            window.addEventListener('scroll', () => {
                const sections = ['hero', 'requirements', 'facilities', 'features'];
                const navHeight = document.querySelector('.navbar').offsetHeight;

                let currentSection = '';

                sections.forEach(sectionId => {
                    const section = document.getElementById(sectionId);
                    if (section) {
                        const sectionTop = section.offsetTop - navHeight -
                            100; // Added offset for better activation
                        const sectionBottom = sectionTop + section.offsetHeight;

                        if (window.scrollY >= sectionTop && window.scrollY < sectionBottom) {
                            currentSection = sectionId;
                        }
                    }
                });

                // Update active state in navbar
                document.querySelectorAll('.nav-link').forEach(link => {
                    const href = link.getAttribute('href');
                    if (href === `#${currentSection}`) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            });
        });
    </script>
@endpush
