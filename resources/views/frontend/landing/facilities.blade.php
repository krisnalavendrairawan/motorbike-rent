<section class="facilities-section section-padding" id="facilities">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-6 offset-lg-3 text-center">
                <h6 class="section-subtitle">Fasilitas</h6>
                <h2 class="section-title">Yang Kami Berikan</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div id="facilityCarousel" class="carousel slide facility-carousel" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#facilityCarousel" data-bs-slide-to="0"
                            class="active"></button>
                        <button type="button" data-bs-target="#facilityCarousel" data-bs-slide-to="1"></button>
                    </div>

                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="facility-card">
                                        <div class="facility-icon">
                                            <img src="{{ asset('assets/img/elements/helmet.png') }}" alt="Logo"
                                                width="100" height="80">
                                        </div>
                                        <h4>Helm SNI</h4>
                                        <p>2 unit helm SNI yang nyaman digunakan untuk keselamatan berkendara
                                            Anda</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="facility-card">
                                        <div class="facility-icon">
                                            <img src="{{ asset('assets/img/elements/tools.png') }}" alt="Logo"
                                                width="100" height="80">
                                        </div>
                                        <h4>Toolkit</h4>
                                        <p>Peralatan standar untuk keadaan darurat selama perjalanan Anda</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="facility-card">
                                        <div class="facility-icon">
                                            <img src="{{ asset('assets/img/elements/jas.png') }}" alt="Logo"
                                                width="100" height="80">
                                        </div>
                                        <h4>Jas Hujan</h4>
                                        <p>Jas hujan berkualitas untuk melindungi Anda saat cuaca hujan</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="facility-card">
                                        <div class="facility-icon">
                                            <img src="{{ asset('assets/img/elements/support.png') }}" alt="Logo"
                                                width="100" height="80">
                                        </div>
                                        <h4>24/7 Support</h4>
                                        <p>Dukungan teknis 24 jam untuk bantuan darurat kapanpun Anda butuhkan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#facilityCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#facilityCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            // Requirements Section Animations
            const requirementsCards = gsap.utils.toArray('.requirements-section .requirements-card');
            requirementsCards.forEach((card, i) => {
                gsap.from(card, {
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 80%',
                    },
                    y: 50,
                    opacity: 0,
                    duration: 0.8,
                    delay: i * 0.2,
                    ease: 'power3.out'
                });
            });

            gsap.from('.requirement-image', {
                scrollTrigger: {
                    trigger: '.requirement-image',
                    start: 'top 70%',
                },
                x: 100,
                opacity: 0,
                duration: 1,
                ease: 'power3.out'
            });

            // Facilities Section Animations
            const facilityCards = gsap.utils.toArray('.facility-card');
            facilityCards.forEach((card, i) => {
                gsap.from(card, {
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 80%',
                    },
                    y: 30,
                    opacity: 0,
                    duration: 0.8,
                    delay: i * 0.2,
                    ease: 'power3.out'
                });
            });

            // Hover animations for all cards
            const allCards = document.querySelectorAll('.requirements-card, .facility-card');
            allCards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    gsap.to(card, {
                        scale: 1.03,
                        duration: 0.3
                    });
                });

                card.addEventListener('mouseleave', () => {
                    gsap.to(card, {
                        scale: 1,
                        duration: 0.3
                    });
                });
            });

            // Rotate animation for facility icons
            gsap.to('.facility-icon', {
                rotate: 360,
                duration: 20,
                repeat: -1,
                ease: 'none'
            });
        });
    </script>
@endpush
