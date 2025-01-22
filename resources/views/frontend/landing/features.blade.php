@push('styles')
    <style>
    </style>
@endpush

<section class="features-section" id="features">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img src="{{ asset('assets/img/elements/motor2.png') }}" alt="Vehicle" class="vehicle-image">
            </div>
            <div class="col-lg-6 features-content">
                <h2>Kenapa Memilih Kami? Ini 4 Keunggulan Kami</h2>
                <p class="features-description">
                    Nikmati perjalanan Anda dengan kenyamanan dan fleksibilitas bersama Motorin, pilihan utama untuk rental motor. Apakah anda merencanakan perjalanan jauh, liburan akhir pekan, aatau sekadar membutuhkan kendaraan yang dapat diandalkan untuk perjalanan harian Anda, Motorin siap membantu anda.
                </p>

                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon">
                            {{ svg('heroicon-o-paper-airplane') }}
                        </div>
                        <div class="feature-content">
                            <h3 class="feature-title">Harga yang Bersaing</h3>
                            <p class="feature-text">Harga yang kami tawarkan terjangkau, bahkan sangat bersaing dengan
                                rentalan lainnya.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            {{ svg('heroicon-m-currency-dollar') }}
                        </div>
                        <div class="feature-content">
                            <h3 class="feature-title">Pembayaran Mudah</h3>
                            <p class="feature-text">Untuk mempermudah pembayaran kami menerima transfer bank, bisa juga
                                melakukan pembayaran secara cash.
                            </p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            {{ svg('heroicon-s-sparkles') }}
                        </div>
                        <div class="feature-content">
                            <h3 class="feature-title">Motor Terawat dan Bersih</h3>
                            <p class="feature-text">Motor kami selalu dalam keadaan prima dan rutin di maintenance.
                                selain itu sepeda motor dalam kondisi siap pakai, bersih dan kinclong.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            {{ svg('heroicon-o-rocket-launch') }}
                        </div>
                        <div class="feature-content">
                            <h3 class="feature-title">Fast Response</h3>
                            <p class="feature-text">Untuk memberikan kemudahan bagi pelanggan kami, kami selalu siap
                                melayani konsumen kami baik online maupun offline.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        function initFeaturesAnimations() {
            // Set initial states
            gsap.set('.vehicle-image', {
                x: -100,
                opacity: 0,
                visibility: 'visible'
            });

            gsap.set('.features-content', {
                y: 50,
                opacity: 0,
                visibility: 'visible'
            });

            gsap.set('.feature-item', {
                x: 50,
                opacity: 0,
                visibility: 'visible'
            });

            gsap.set('.about-btn', {
                y: 20,
                opacity: 0,
                visibility: 'visible'
            });

            // Create main timeline
            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: '.features-section',
                    start: 'top 60%',
                    end: 'bottom 20%',
                }
            });

            // Add animations to timeline
            tl.to('.vehicle-image', {
                    x: 0,
                    opacity: 1,
                    duration: 1,
                    ease: 'power3.out'
                })
                .to('.features-content', {
                    y: 0,
                    opacity: 1,
                    duration: 1,
                    ease: 'power3.out'
                }, '-=0.5')
                .to('.feature-item', {
                    x: 0,
                    opacity: 1,
                    stagger: 0.2,
                    duration: 0.8,
                    ease: 'power3.out'
                }, '-=0.5')
                .to('.about-btn', {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    ease: 'power3.out'
                }, '-=0.3');

            // Add hover animations for feature items
            const featureItems = document.querySelectorAll('.feature-item');
            featureItems.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    gsap.to(item, {
                        scale: 1.02,
                        backgroundColor: 'rgba(0, 0, 0, 0.04)',
                        duration: 0.3
                    });
                });

                item.addEventListener('mouseleave', () => {
                    gsap.to(item, {
                        scale: 1,
                        backgroundColor: 'rgba(0, 0, 0, 0.02)',
                        duration: 0.3
                    });
                });
            });
        }

        // Initialize on DOM load
        document.addEventListener('DOMContentLoaded', initFeaturesAnimations);
    </script>
@endpush
