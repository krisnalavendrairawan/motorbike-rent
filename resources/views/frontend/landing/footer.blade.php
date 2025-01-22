@push('styles')
    <style>

    </style>
@endpush

<footer class="footer">
    <div class="container">
        <div class="row footer-content">
            <!-- Company Info -->
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="footer-logo">Motorin</div>
                <p class="footer-description">
                    Your trusted partner for vehicle rentals. Making transportation accessible, convenient, and
                    affordable for everyone.
                </p>
                <div class="social-links">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-twitter"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h3 class="footer-title">Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Vehicles</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>


            <!-- Contact Info -->
            <div class="col-lg-4 col-md-6">
                <h3 class="footer-title">Contact Us</h3>
                <div class="footer-contact-info">
                    <div class="footer-contact-item">
                        <i class="bi bi-geo-alt"></i>
                        <span>Gedung Sate, Jl. Diponegoro No.22, Bandung</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-telephone"></i>
                        <span>+62 123 456 7890</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-envelope"></i>
                        <span>contact@motorin.com</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-clock"></i>
                        <span>Senin - Sabtu: 08:00 - 22:00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <p>&copy; 2024 Motorin. All rights reserved.</p>
        </div>
    </div>
</footer>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            // Footer animation
            gsap.set('.footer-content', {
                opacity: 0,
                y: 20
            });

            ScrollTrigger.create({
                trigger: '.footer',
                start: 'top 80%',
                onEnter: () => {
                    gsap.to('.footer-content', {
                        opacity: 1,
                        y: 0,
                        duration: 1,
                        ease: 'power3.out'
                    });
                }
            });

            // Social links hover animation
            const socialLinks = document.querySelectorAll('.social-links a');
            socialLinks.forEach(link => {
                link.addEventListener('mouseenter', () => {
                    gsap.to(link, {
                        scale: 1.1,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });

                link.addEventListener('mouseleave', () => {
                    gsap.to(link, {
                        scale: 1,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });
            });
        });
    </script>
@endpush
