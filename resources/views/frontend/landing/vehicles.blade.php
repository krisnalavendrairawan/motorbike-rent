<section class="vehicles-section">
    <div class="container">
        <h2 class="section-title text-center mb-5">Available Vehicles</h2>

        <div class="row g-4" id="vehicles-container">
            @include('frontend.landing.vehicle-cards')
        </div>

        @if($motor->count() > 0)
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item {{ $motor->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="javascript:void(0)" data-page="{{ $motor->currentPage() - 1 }}">Previous</a>
                        </li>
                        
                        @for ($i = 1; $i <= $totalPages; $i++)
                            <li class="page-item {{ ($motor->currentPage() == $i) ? 'active' : '' }}">
                                <a class="page-link" href="javascript:void(0)" data-page="{{ $i }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="page-item {{ $motor->currentPage() == $totalPages ? 'disabled' : '' }}">
                            <a class="page-link" href="javascript:void(0)" data-page="{{ $motor->currentPage() + 1 }}">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    gsap.registerPlugin(ScrollTrigger);
    
    function animateCards() {
        const cards = gsap.utils.toArray('.vehicle-card');
        
        // Set initial state
        cards.forEach(card => {
            gsap.set(card, { 
                opacity: 0,
                y: 50,
                visibility: 'visible'
            });
        });
        
        // Create timeline for cards animation
        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: '.vehicles-section',
                start: 'top 60%',
                end: 'bottom 20%',
            }
        });

        // Add cards to timeline with stagger effect
        tl.to('.vehicle-card', {
            duration: 0.8,
            opacity: 1,
            y: 0,
            stagger: 0.2,
            ease: 'power3.out'
        });
    }

    // Initial animation
    animateCards();

    // Handle pagination clicks
    document.querySelectorAll('.pagination .page-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            if(this.parentElement.classList.contains('disabled')) return;
            
            const page = this.dataset.page;
            
            fetch(`?page=${page}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('vehicles-container').innerHTML = data.html;
                
                // Update pagination active state
                document.querySelectorAll('.pagination .page-item').forEach(item => {
                    item.classList.remove('active');
                });
                document.querySelector(`.pagination .page-item:nth-child(${parseInt(page) + 1})`).classList.add('active');
                
                // Update prev/next disabled states
                document.querySelector('.pagination .page-item:first-child').classList.toggle('disabled', page == 1);
                document.querySelector('.pagination .page-item:last-child').classList.toggle('disabled', page == data.lastPage);
                
                // Animate new cards
                animateCards();
            });
        });
    });
});
</script>
@endpush