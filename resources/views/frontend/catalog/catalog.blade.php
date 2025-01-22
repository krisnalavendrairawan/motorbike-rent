@extends('frontend.catalog.index')

@section('content')
    <div class="container py-5">
        <!-- Search and Filters Section -->
        <div class="row g-3 mb-4 fade-in">
            <div class="col-12 col-md-6">
                <div class="search-box">
                    <i class='bx bx-search position-absolute top-50 start-0 translate-middle-y ms-3'></i>
                    <input type="text" class="form-control form-control-lg ps-5" id="searchInput"
                        placeholder="Search motorcycles..." style="border-radius: 50px;">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <select class="form-select form-select-lg" id="brandFilter" style="border-radius: 50px;">
                    <option value="">All Brands</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3">
                <select class="form-select form-select-lg" id="typeFilter" style="border-radius: 50px;">
                    <option value="">All Types</option>
                    @foreach ($types as $key => $type)
                        <option value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Motors Grid -->
        <div id="motorsContainer">
            @include('frontend.catalog.vehicle-cards', ['motors' => $motors])
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .catalog-header {
            background: linear-gradient(135deg, #696cff 0%, #4844ff 100%);
            position: relative;
            overflow: hidden;
            opacity: 0;
        }

        .catalog-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        }

        .search-box {
            position: relative;
        }

        .vehicle-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            opacity: 0;
            transform: translateY(30px);
        }

        .vehicle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .vehicle-img {
            height: 200px;
            object-fit: cover;
        }

        .badge-custom {
            font-size: 0.8rem;
            padding: 0.5em 1em;
            border-radius: 50px;
        }

        .price-tag {
            background: #696cff;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: bold;
        }

        .pagination {
            margin: 2rem 0;
            gap: 5px;
            opacity: 0;
        }

        .page-link {
            border-radius: 50px;
            padding: 0.5rem 1rem;
            color: #696cff;
            border: 1px solid #696cff;
        }

        .page-item.active .page-link {
            background-color: #696cff;
            border-color: #696cff;
        }

        .page-link:hover {
            background-color: #4844ff;
            color: white;
            border-color: #4844ff;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(20px);
        }
    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let timer;
            const delay = 500;

            gsap.to('.catalog-header', {
                opacity: 1,
                duration: 1,
                ease: 'power2.out'
            });

            gsap.to('.fade-in', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 0.3,
                ease: 'power2.out'
            });

            function animateCards() {
                const cards = document.querySelectorAll('.vehicle-card');
                gsap.set(cards, {
                    opacity: 0,
                    y: 30
                });

                gsap.to(cards, {
                    opacity: 1,
                    y: 0,
                    duration: 0.6,
                    stagger: {
                        amount: 0.8,
                        grid: [3, 3],
                        from: "start"
                    },
                    ease: "power2.out"
                });

                const pagination = document.querySelector('.pagination');
                if (pagination) {
                    gsap.to(pagination, {
                        opacity: 1,
                        duration: 0.5,
                        delay: 0.5
                    });
                }
            }

            animateCards();

            function fetchMotors(page = null) {
                const search = document.getElementById('searchInput').value;
                const brand = document.getElementById('brandFilter').value;
                const type = document.getElementById('typeFilter').value;

                const container = document.getElementById('motorsContainer');
                gsap.to(container, {
                    opacity: 0.5,
                    duration: 0.2
                });

                const params = new URLSearchParams();
                if (search) params.append('search', search);
                if (brand) params.append('brand', brand);
                if (type) params.append('type', type);
                if (page) params.append('page', page);

                fetch(`${window.location.pathname}?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        container.innerHTML = data.html;
                        gsap.to(container, {
                            opacity: 1,
                            duration: 0.2
                        });

                        animateCards();

                        const url = new URL(window.location);
                        if (search) url.searchParams.set('search', search);
                        else url.searchParams.delete('search');
                        if (brand) url.searchParams.set('brand', brand);
                        else url.searchParams.delete('brand');
                        if (type) url.searchParams.set('type', type);
                        else url.searchParams.delete('type');
                        if (page) url.searchParams.set('page', page);
                        else url.searchParams.delete('page');
                        window.history.pushState({}, '', url);

                        initializePagination();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        gsap.to(container, {
                            opacity: 1,
                            duration: 0.2
                        });
                    });
            }

            function initializePagination() {
                document.querySelectorAll('.pagination .page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = new URL(this.href).searchParams.get('page');
                        fetchMotors(page);

                        document.getElementById('motorsContainer').scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    });
                });
            }

            document.getElementById('searchInput').addEventListener('input', (e) => {
                clearTimeout(timer);
                timer = setTimeout(() => fetchMotors(), delay);
            });

            document.getElementById('brandFilter').addEventListener('change', () => fetchMotors());
            document.getElementById('typeFilter').addEventListener('change', () => fetchMotors());

            initializePagination();

            // Add scroll trigger animation for cards
            gsap.registerPlugin(ScrollTrigger);
            ScrollTrigger.batch(".vehicle-card", {
                onEnter: batch => gsap.to(batch, {
                    opacity: 1,
                    y: 0,
                    stagger: 0.15,
                    duration: 0.6,
                    ease: "power2.out"
                }),
                once: true
            });

            
        });
        
    </script>
@endpush
