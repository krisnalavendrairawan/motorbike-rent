<section class="faq-section py-5 position-relative">
    <div class="container">
        <h2 class="section-title text-center mb-5" data-aos="fade-up">
            <span class="text-primary">Pertanyaan </span> yang Sering Diajukan
        </h2>

        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                <div class="accordion custom-accordion" id="faqAccordion">
                    <!-- FAQ Item 1 -->
                    <div class="accordion-item border-0 mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq1">
                                <i class="fas fa-question-circle text-primary me-2"></i>
                                Dokumen apa saja yang diperlukan untuk menyewa motor?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>Untuk menyewa motor, Anda perlu menyediakan:</p>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>SIM C yang masih berlaku</li>
                                    <li><i class="fas fa-check text-success me-2"></i>KTP atau identitas resmi lainnya</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Deposit jaminan</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Kartu debit/kredit untuk pembayaran</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="accordion-item border-0 mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq2">
                                <i class="fas fa-question-circle text-primary me-2"></i>
                                Apa saja yang termasuk dalam biaya sewa?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Biaya sewa kami mencakup:
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>Peminjaman sepeda motor</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Asuransi dasar</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Helm dan perlengkapan keselamatan</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Bantuan darurat 24/7</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="accordion-item border-0 mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq3">
                                <i class="fas fa-question-circle text-primary me-2"></i>
                                Apakah motor perlu diisi bensin sebelum dikembalikan?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya, kami meminta pelanggan untuk mengembalikan motor dengan jumlah bensin yang sama seperti saat diterima.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="accordion-item border-0 mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq4">
                                <i class="fas fa-question-circle text-primary me-2"></i>
                                Bagaimana jika motor mengalami kerusakan saat disewa?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Jika terjadi kerusakan, pelanggan diharuskan melaporkan segera ke pihak kami. Biaya perbaikan akan ditanggung sesuai dengan kesepakatan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Animated background elements -->
    <div class="faq-shapes">
        <div class="shape-1"></div>
        <div class="shape-2"></div>
    </div>
</section>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            // Timeline untuk animasi FAQ
            const tlFaq = gsap.timeline({
                scrollTrigger: {
                    trigger: '.faq-section',
                    start: 'top 60%',
                    end: 'bottom 20%',
                }
            });

            // Set initial states
            gsap.set('.faq-section .section-title', {
                y: 20,
                opacity: 0,
                visibility: 'visible'
            });

            gsap.set('.custom-accordion .accordion-item', {
                y: 20,
                opacity: 0,
                visibility: 'visible'
            });

            // Animasi
            tlFaq.to('.faq-section .section-title', {
                    y: 0,
                    opacity: 1,
                    duration: 1,
                    ease: 'power3.out'
                })
                .to('.custom-accordion .accordion-item', {
                    y: 0,
                    opacity: 1,
                    stagger: 0.2,
                    duration: 0.8,
                    ease: 'power3.out'
                }, '-=0.5');

            // Hover animation untuk accordion items
            const accordionItems = document.querySelectorAll('.accordion-item');
            accordionItems.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    gsap.to(item, {
                        scale: 1.01,
                        duration: 0.3
                    });
                });

                item.addEventListener('mouseleave', () => {
                    gsap.to(item, {
                        scale: 1,
                        duration: 0.3
                    });
                });
            });
        });
    </script>
@endpush
