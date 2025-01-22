@push('styles')
    <style>

    </style>
@endpush

<section class="about-section " id="about">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6">
                <div class="about-content">
                    <h6 class="section-subtitle">Tentang Kami</h6>
                    <h2 class="section-title">Motorin Rental Jatinangor</h2>
                    <p class="about-description">
                        Motorin Rental Jatinangor adalah penyedia jasa rental sepeda motor terpercaya di kota Sumedang,
                        Jawa Barat.
                        Kami berkomitmen memberikan layanan rental motor berkualitas dengan unit-unit terbaru dan
                        terawat untuk
                        memenuhi kebutuhan transportasi anda, baik untuk wisatawan, pegawai, karyawan maupun wiraswasta.
                    </p>
                    <div class="features-list">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <span class="feature-text">Unit Terpercaya</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-stars"></i>
                            </div>
                            <span class="feature-text">Pelayanan Prima</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-gear"></i>
                            </div>
                            <span class="feature-text">Terawat Berkala</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <span class="feature-text">Harga Bersaing</span>
                        </div>
                    </div>
                    <div class="brands-available mt-4">
                        <p class="mb-2"><strong>Tersedia berbagai merk:</strong></p>
                        <p>Honda • Yamaha • Suzuki • dan merk lainnya</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image-container">
                    <img src="{{ asset('assets/img/elements/motor3.png') }}" alt="Axe Rental Motor Medan"
                        class="about-image">
                    <div class="experience-badge">
                        <span class="experience-number">5+</span>
                        <span class="experience-text">Years Experience</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            // Create timeline for about section animations
            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: '.about-section',
                    start: 'top 60%',
                    end: 'bottom 20%',
                }
            });

            // Add animations to timeline
            tl.fromTo('.about-image-container', {
                    x: -100,
                    opacity: 0
                }, {
                    x: 0,
                    opacity: 1,
                    duration: 1,
                    ease: 'power3.out'
                })
                .fromTo('.about-content', {
                    x: 100,
                    opacity: 0
                }, {
                    x: 0,
                    opacity: 1,
                    duration: 1,
                    ease: 'power3.out'
                }, '-=0.5')
                .fromTo('.feature-item', {
                    y: 20,
                    opacity: 0
                }, {
                    y: 0,
                    opacity: 1,
                    stagger: 0.2,
                    duration: 0.8,
                    ease: 'power3.out'
                }, '-=0.5');

            // Add hover animations for feature items
            const featureItems = document.querySelectorAll('.feature-item');
            featureItems.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    gsap.to(item, {
                        scale: 1.05,
                        duration: 0.3
                    });
                    gsap.to(item.querySelector('.feature-icon'), {
                        duration: 0.3
                    });
                });

                item.addEventListener('mouseleave', () => {
                    gsap.to(item, {
                        scale: 1,
                        duration: 0.3

                    });
                    gsap.to(item.querySelector('.feature-icon'), {
                        duration: 0.3
                    });
                });
            });
        });
    </script>
@endpush
