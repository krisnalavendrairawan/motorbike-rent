@push('styles')
    <style>
    </style>
@endpush

<section class="hero-section position-relative overflow-hidden" style="min-height: 100vh;" id="hero">
    <div class="container">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row min-vh-100 align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content-animate">
                        <h1 class="display-4 fw-bold mb-2 text-dark">
                            Selamat datang di<br>
                            website resmi <span style="color: #FFB800">Motorin Rental</span> Yogyakarta
                        </h1>

                        <p class="lead mb-4 text-secondary">
                            Motorin Rental adalah jasa rental sepeda motor di daerah Jatinangor, Kota Sumedang, Jawa
                            Barat. kami melayani jasa rental motor jatinangor untuk harian, mingguan, bulanan. Sewa
                            motor dengan unit yang baru dan prima. Penyewaan sepeda motor untuk wisatawan, pegawai,
                            karyawan, ataupun wiraswasta. sewa motor dengan berbagai jenis unit dari merk terkenal di
                            indonesia seperti Honda, Yamaha, Suzuki, dan merk lainnya.
                        </p>

                        <a href="{{ route('catalog.index') }}" class="btn btn-warning btn-lg px-4">
                            {{ svg('carbon-catalog', ['width' => 24, 'height' => 24]) }}
                            @auth
                                Lihat Katalog
                            @else
                                Login Untuk Melihat Katalog
                            @endauth
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="position-absolute top-0 end-0 h-100 w-50 hero-image-animate" style="z-index: 0;">
            <img src="{{ asset('assets/img/elements/map.png') }}" alt="Map Background"
                class="position-absolute w-100 h-100" style="object-fit: cover; z-index: -1; opacity: 0.4;">

            <img src="{{ asset('assets/img/elements/motor1.png') }}" alt="Motorcycle"
                class="position-absolute w-100 h-100" style="object-fit: contain; z-index: 1; mix-blend-mode: screen;">
        </div>
    </div>
</section>

@push('scripts')
    <script>
        function initHeroAnimations() {
            // Set initial states
            gsap.set('.hero-content-animate', {
                x: -100,
                opacity: 0,
                visibility: 'visible'
            });

            gsap.set('.hero-image-animate', {
                x: 100,
                opacity: 0,
                visibility: 'visible'
            });

            // Create timeline
            const tl = gsap.timeline({
                defaults: {
                    duration: 1,
                    ease: 'power3.out'
                }
            });

            // Add animations to timeline
            tl.to('.hero-content-animate', {
                    x: 0,
                    opacity: 1,
                })
                .to('.hero-image-animate', {
                    x: 0,
                    opacity: window.innerWidth <= 991.98 ? 0.2 : 1,
                }, '-=0.5'); // Start slightly before previous animation ends

            // Add ScrollTrigger
            ScrollTrigger.create({
                trigger: '.hero-section',
                start: 'top center',
                onEnter: () => tl.play(),
                onLeaveBack: () => tl.reverse()
            });
        }

        // Initialize on DOM load
        document.addEventListener('DOMContentLoaded', initHeroAnimations);

        // Reinitialize on window resize
        window.addEventListener('resize', () => {
            gsap.to('.hero-image-animate', {
                opacity: window.innerWidth <= 991.98 ? 0.2 : 1,
                duration: 0.3
            });
        });
    </script>
@endpush
