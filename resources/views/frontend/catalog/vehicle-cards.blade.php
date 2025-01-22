<div class="row g-4">
    @forelse($motors as $bike)
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card vehicle-card h-100 shadow-sm">
                <div class="position-relative">
                    <div class="{{ pathinfo($bike->image, PATHINFO_EXTENSION) === 'png' ? 'p-4' : '' }}">
                        <img src="{{ asset('storage/' . $bike->image) }}"
                            class="card-img-top vehicle-img {{ pathinfo($bike->image, PATHINFO_EXTENSION) === 'png' ? 'p-2' : '' }}"
                            alt="{{ $bike->name }}"
                            style="height: 250px; object-fit: {{ pathinfo($bike->image, PATHINFO_EXTENSION) === 'png' ? 'contain' : 'cover' }};">
                    </div>
                    <div class="position-absolute top-0 end-0 p-2">
                        <span class="badge badge-custom bg-{{ $bike->status === 'ready' ? 'success' : 'danger' }}">
                            {{ $bike->status === 'ready' ? 'Ready' : 'Not Ready' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $bike->name }}</h5>
                    <p class="text-muted small mb-2">
                        <i class='bx bxs-badge'></i> {{ $bike->plate }}
                    </p>
                    <div class="mb-3">
                        <span class="badge badge-custom bg-primary">{{ $bike->brand->name }}</span>
                        <span class="badge badge-custom bg-info">{{ $bike->type }}</span>
                        <span class="badge badge-custom {{ strtolower($bike->color) === 'white' ? 'bg-primary' : '' }}"
                            style="background-color: {{ strtolower($bike->color) === 'white' ? '' : $bike->color }}">
                            {{ $bike->color }}
                        </span>
                    </div>
                    <p class="card-text text-truncate" title="{{ $bike->description }}">
                        {{ $bike->description }}
                    </p>
                    <h6 class="price-tag d-inline-block">
                        Rp {{ number_format($bike->price, 0, ',', '.') }} / Days
                    </h6>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('catalog.detail', $bike->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class='bx bxs-show'></i> Detail
                        </a>
                        @if ($bike->status === 'ready')
                            <a href="{{ route('customer.rental', $bike->id) }}" class="btn btn-primary btn-sm">
                                <i class='bx bxs-wallet'></i> Book
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center fade-in">
                No bikes available yet.
            </div>
        </div>
    @endforelse
</div>

{{-- pagination --}}

@if ($motors->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @if ($motors->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $motors->previousPageUrl() }}" rel="prev">Previous</a>
                    </li>
                @endif

                @foreach ($motors->getUrlRange(1, $motors->lastPage()) as $page => $url)
                    @if ($page == $motors->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                @if ($motors->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $motors->nextPageUrl() }}" rel="next">Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Next</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif

@push('styles')
    <style>
        .vehicle-card {
            opacity: 0;
            transform: translateY(30px);
            transition: transform 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }

        .vehicle-card:hover {
            transform: translateY(-5px);
        }

        .vehicle-img {
            transition: transform 0.3s ease;
        }

        .vehicle-card:hover .vehicle-img {
            transform: scale(1.05);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            const cards = gsap.utils.toArray('.vehicle-card');

            cards.forEach((card, i) => {
                gsap.to(card, {
                    opacity: 1,
                    y: 0,
                    duration: 0.8,
                    delay: i * 0.1,
                    ease: "power3.out",
                    scrollTrigger: {
                        trigger: card,
                        start: "top bottom-=100",
                        once: true
                    }
                });
            });
        });
    </script>
    </script>
@endpush
