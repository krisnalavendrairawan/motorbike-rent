@push('styles')
    <style>
        /* Keep your existing styles */
    </style>
@endpush

<section>
    <div class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="bi bi-people-fill stat-icon"></i>
                        <div class="stat-number" data-value="{{ $staffCount }}">0</div>
                        <div class="stat-description">
                            Total Staff & Admin yang siap
                            melayani kebutuhan rental
                            anda
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card highlighted">
                        <i class="bi bi-motorcycle stat-icon"></i>
                        <div class="stat-number" data-value="{{ $motorCount }}">0</div>
                        <div class="stat-description">
                            Unit motor yang tersedia
                            untuk memenuhi kebutuhan
                            transportasi anda
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="bi bi-person-check-fill stat-icon"></i>
                        <div class="stat-number" data-value="{{ $customerCount }}">0</div>
                        <div class="stat-description">
                            Pelanggan setia yang telah
                            mempercayakan kebutuhan
                            transportasinya kepada kami
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function initStatsAnimations() {
        const cards = gsap.utils.toArray('.stat-card');

        // Set initial states
        gsap.set(cards, {
            opacity: 0,
            y: 50,
            visibility: 'visible'
        });

        // Create timeline for cards animation
        const cardsTl = gsap.timeline({
            scrollTrigger: {
                trigger: '.stats-section',
                start: 'top 80%',
                end: 'bottom 20%',
            }
        });

        // Animate cards one by one
        cards.forEach((card, index) => {
            cardsTl.to(card, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out'
            }, index * 0.2);
        });

        // Animate numbers
        const numbers = gsap.utils.toArray('.stat-number');
        numbers.forEach((number, index) => {
            const value = parseInt(number.getAttribute('data-value'));

            ScrollTrigger.create({
                trigger: number,
                start: 'top 80%',
                onEnter: () => {
                    gsap.to(number, {
                        duration: 2,
                        textContent: value,
                        roundProps: 'textContent',
                        ease: 'power1.inOut',
                        modifiers: {
                            textContent: value => {
                                const text = Math.round(value);
                                // Add appropriate suffix based on the index
                                if (index === 0) return text + '+ Staff';
                                if (index === 1) return text + '+ Motor';
                                return text + '+ Pelanggan';
                            }
                        }
                    });
                },
                once: true
            });
        });
    }

    // Initialize on DOM load
    document.addEventListener('DOMContentLoaded', initStatsAnimations);
</script>
@endpush