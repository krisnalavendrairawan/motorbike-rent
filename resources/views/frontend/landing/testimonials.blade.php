<section class="testimonials-section py-5 position-relative overflow-hidden">
    <div class="container">
        <h2 class="section-title text-center mb-5 testimonial-title">
            Review dari <span class="text-primary">Customers</span>
        </h2>

        <div id="testimonialCarousel" class="carousel slide testimonial-carousel" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2"></button>
            </div>
            
            <div class="carousel-inner">
                <!-- Testimonial 1 -->
                <div class="carousel-item active">
                    <div class="testimonial-card text-center">
                        <div class="testimonial-image">
                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Customer"
                                class="rounded-circle mb-4 mx-auto shadow-lg hover-scale">
                        </div>
                        <div class="testimonial-quote mb-4">
                            <i class="fas fa-quote-left text-primary opacity-25 display-3"></i>
                        </div>
                        <p class="testimonial-text mb-4">"The service exceeded my expectations! The motorcycle was in
                            pristine condition and the staff was incredibly helpful."</p>
                        <div class="rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <h5 class="customer-name mb-1">John Doe</h5>
                        <p class="customer-title text-muted">Adventure Enthusiast</p>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="carousel-item">
                    <div class="testimonial-card text-center">
                        <div class="testimonial-image">
                            <img src="{{ asset('assets/img/avatars/5.png') }}" alt="Customer"
                                class="rounded-circle mb-4 mx-auto shadow-lg hover-scale">
                        </div>
                        <div class="testimonial-quote mb-4">
                            <i class="fas fa-quote-left text-primary opacity-25 display-3"></i>
                        </div>
                        <p class="testimonial-text mb-4">"Professional service and well-maintained vehicles. The booking
                            process was smooth and hassle-free!"</p>
                        <div class="rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <h5 class="customer-name mb-1">Sarah Johnson</h5>
                        <p class="customer-title text-muted">Regular Customer</p>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="carousel-item">
                    <div class="testimonial-card text-center">
                        <div class="testimonial-image">
                            <img src="{{ asset('assets/img/avatars/6.png') }}" alt="Customer"
                                class="rounded-circle mb-4 mx-auto shadow-lg hover-scale">
                        </div>
                        <div class="testimonial-quote mb-4">
                            <i class="fas fa-quote-left text-primary opacity-25 display-3"></i>
                        </div>
                        <p class="testimonial-text mb-4">"Professional service and well-maintained vehicles. The booking
                            process was smooth and hassle-free!"</p>
                        <div class="rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <h5 class="customer-name mb-1">Michael Brown</h5>
                        <p class="customer-title text-muted">Business Traveler</p>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <!-- Background decoration -->
    <div class="decoration-bg"></div>
</section>

@push('styles')
<style>

</style>
@endpush

@push('scripts')
<script>
    function initTestimonialsAnimations() {
        // Set initial states
        gsap.set('.testimonials-section', {
            opacity: 0,
            visibility: 'visible'
        });

        gsap.set('.testimonial-title', {
            y: 30,
            opacity: 0
        });

        gsap.set('.testimonial-carousel', {
            y: 50,
            opacity: 0
        });

        // Create timeline
        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: '.testimonials-section',
                start: 'top 60%',
                end: 'bottom 20%',
            }
        });

        // Add animations
        tl.to('.testimonials-section', {
                opacity: 1,
                duration: 1,
                ease: 'power3.out'
            })
            .to('.testimonial-title', {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.5')
            .to('.testimonial-carousel', {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.3');
    }

    // Initialize on DOM load
    document.addEventListener('DOMContentLoaded', function() {
        initTestimonialsAnimations();
        
        // Initialize Bootstrap carousel
        new bootstrap.Carousel(document.getElementById('testimonialCarousel'), {
            interval: 5000,
            touch: true
        });
    });
</script>
@endpush