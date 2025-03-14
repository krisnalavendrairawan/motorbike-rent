<footer class="footer bg-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            <!-- Company info -->
            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <a href="{{ route('landing.index') }}" class="d-inline-block mb-3">
                        <span class="motorin-text footer-brand">MOTORIN</span>
                    </a>
                    <p class="text-muted mt-3">Layanan sewa sepeda motor terpercaya Anda yang menyediakan sepeda berkualitas untuk perjalanan Anda.</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="text-decoration-none social-icon">
                            <i class="bx bxl-facebook fs-4"></i>
                        </a>
                        <a href="#" class="text-decoration-none social-icon">
                            <i class="bx bxl-instagram fs-4"></i>
                        </a>
                        <a href="#" class="text-decoration-none social-icon">
                            <i class="bx bxl-twitter fs-4"></i>
                        </a>
                        <a href="#" class="text-decoration-none social-icon">
                            <i class="bx bxl-whatsapp fs-4"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Quick links -->
            <div class="col-lg-2 col-md-6">
                <h5 class="fw-bold mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('landing.index') }}" class="text-decoration-none text-muted">
                            <i class="bx bx-chevron-right me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('catalog.index') }}" class="text-decoration-none text-muted">
                            <i class="bx bx-chevron-right me-1"></i>Katalog
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-decoration-none text-muted">
                            <i class="bx bx-chevron-right me-1"></i>Tentang Kami
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-decoration-none text-muted">
                            <i class="bx bx-chevron-right me-1"></i>Syarat & Ketentuan
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Service hours -->
            <div class="col-lg-3 col-md-6">
                <h5 class="fw-bold mb-3">Jam Operasional</h5>
                <ul class="list-unstyled">
                    <li class="mb-2 d-flex justify-content-between text-muted">
                        <span>Senin - Jumat:</span>
                        <span>08:00 - 20:00</span>
                    </li>
                    <li class="mb-2 d-flex justify-content-between text-muted">
                        <span>Sabtu:</span>
                        <span>09:00 - 18:00</span>
                    </li>
                    <li class="mb-2 d-flex justify-content-between text-muted">
                        <span>Minggu:</span>
                        <span>10:00 - 16:00</span>
                    </li>
                </ul>
                <div class="mt-3 py-2 px-3 bg-primary bg-opacity-10 rounded-3 d-flex align-items-center">
                    <i class="bx bx-phone-call me-2 fs-4 text-primary"></i>
                    <div>
                        <small class="d-block text-muted">Customer Service</small>
                        <span class="fw-bold">+1234567890</span>
                    </div>
                </div>
            </div>
            
            <!-- Contact -->
            <div class="col-lg-3 col-md-6">
                <h5 class="fw-bold mb-3">Contact Us</h5>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex">
                        <i class="bx bx-map me-2 fs-5 text-primary"></i>
                        <span class="text-muted">123 Rental Street, City, Country 12345</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <i class="bx bx-envelope me-2 fs-5 text-primary"></i>
                        <span class="text-muted">info@motorin.com</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <i class="bx bx-phone me-2 fs-5 text-primary"></i>
                        <span class="text-muted">+1234567890</span>
                    </li>
                </ul>
                
                <!-- Newsletter -->
                <div class="mt-3">
                    <h6 class="fw-bold">Subscribe to Newsletter</h6>
                    <div class="input-group mt-2">
                        <input type="email" class="form-control" placeholder="Your email" aria-label="Email">
                        <button class="btn btn-primary" type="button">
                            <i class="bx bx-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <hr class="mt-4">
        
        <!-- Bottom footer -->
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-muted">&copy; {{ date('Y') }} MOTORIN. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="d-inline-flex gap-3">
                    <a href="#" class="text-decoration-none text-muted small">Privacy Policy</a>
                    <a href="#" class="text-decoration-none text-muted small">Terms of Service</a>
                    <a href="#" class="text-decoration-none text-muted small">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.motorin-text {
    font-family: 'Poppins', sans-serif;
    font-size: 1.8rem;
    letter-spacing: 1px;
    background: linear-gradient(45deg, #3498db, #2c3e50);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    position: relative;
    display: inline-block;
    padding-bottom: 2px;
}

.motorin-text::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(45deg, #3498db, #2c3e50);
    border-radius: 2px;
}

.footer-brand {
    font-size: 2rem;
}

.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    color: #3498db;
    background-color: rgba(52, 152, 219, 0.1);
    transition: all 0.3s ease;
}

.social-icon:hover {
    color: white;
    background-color: #3498db;
    transform: translateY(-3px);
}

@media (max-width: 767px) {
    .footer-brand {
        font-size: 1.6rem;
    }
}
</style>