<section class="contact-section py-5 position-relative">
    <div class="container">
        <h2 class="section-title text-center mb-5 contact-title">
            <span class="text-primary">Kontak</span> Kami
        </h2>

        <div class="row g-4">
            <!-- Contact Info -->
            <div class="col-lg-4 contact-info">
                <div class="contact-info-card h-100">
                    <h4 class="mb-4">Contact Information</h4>

                    <div class="contact-item d-flex align-items-center mb-4">
                        <div class="icon-box">
                            {{ svg('entypo-location') }}
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-1">Our Location</h5>
                            <p class="mb-0">Gedung Sate, Jl. Diponegoro No.22, Bandung</p>
                        </div>
                    </div>

                    <div class="contact-item d-flex align-items-center mb-4">
                        <div class="icon-box">
                            {{ svg('heroicon-o-phone') }}
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-1">Phone Number</h5>
                            <p class="mb-0">+62 123 456 7890</p>
                        </div>
                    </div>

                    <div class="contact-item d-flex align-items-center mb-4">
                        <div class="icon-box">
                            {{ svg('heroicon-o-envelope') }}
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-1">Email Address</h5>
                            <p class="mb-0">info@motorental.com</p>
                        </div>
                    </div>

                    <div class="social-links mt-4">
                        <h5 class="mb-3">Follow Us</h5>
                        <a href="#" class="social-link">{{ svg('bi-facebook') }}</a>
                        <a href="#" class="social-link">{{ svg('bi-twitter-x') }}</a>
                        <a href="#" class="social-link">{{ svg('bi-instagram') }}</a>
                        <a href="#" class="social-link">{{ svg('bi-linkedin') }}</a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8 contact-form">
                <div class="contact-form-card h-100">
                    <form id="contactForm" onsubmit="return handleSubmit(event)">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" placeholder="Your Name"
                                        required>
                                    <label for="name">Your Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" placeholder="Your Email"
                                        required>
                                    <label for="email">Your Email</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="subject" placeholder="Subject"
                                        required>
                                    <label for="subject">Subject</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="message" placeholder="Your Message" style="height: 150px" required></textarea>
                                    <label for="message">Your Message</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Map Section -->
            <div class="col-12 mt-5 map-section">
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.990857777558!2d107.61769731474275!3d-6.902199695012432!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64c5e8866e5%3A0x37be7ac9d575f7ed!2sGedung%20Sate!5e0!3m2!1sen!2sid!4v1645524082121!5m2!1sen!2sid"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
    <style>

    </style>
@endpush

@push('scripts')
    <script>
        function initContactAnimations() {
            // Set initial states
            gsap.set('.contact-section', {
                opacity: 0,
                visibility: 'visible'
            });

            // Create timeline
            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: '.contact-section',
                    start: 'top 60%',
                    end: 'bottom 20%',
                }
            });

            // Add animations
            tl.to('.contact-section', {
                    opacity: 1,
                    duration: 1,
                    ease: 'power3.out'
                })
                .to('.contact-info-card', {
                    opacity: 1,
                    y: 0,
                    duration: 0.8,
                    ease: 'power3.out'
                }, '-=0.5')
                .to('.contact-form-card', {
                    opacity: 1,
                    y: 0,
                    duration: 0.8,
                    ease: 'power3.out'
                }, '-=0.5')
                .to('.map-container', {
                    opacity: 1,
                    y: 0,
                    duration: 0.8,
                    ease: 'power3.out'
                }, '-=0.5');
        }

        function handleSubmit(event) {
            event.preventDefault();

            // Get form data
            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                subject: document.getElementById('subject').value,
                message: document.getElementById('message').value
            };

            // Here you would typically send the data to your backend
            console.log('Form submitted:', formData);

            // Show success message using SweetAlert2
            Swal.fire({
                icon: 'success',
                title: 'Message Sent!',
                text: 'We will get back to you soon.',
                confirmButtonColor: '#0d6efd'
            });

            // Reset form
            event.target.reset();

            return false;
        }

        // Initialize on DOM load
        document.addEventListener('DOMContentLoaded', initContactAnimations);
    </script>
@endpush
