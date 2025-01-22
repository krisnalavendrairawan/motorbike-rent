@extends('layouts.backend.index')

@section('title', $title)

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('page-action')
    <li class="breadcrumb-item text-light">
        <x-profile />
    </li>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">{{ __('label.available_bikes') }} ({{ $motorCount }})</h5>
            </div>

            <!-- Search and Filter Section -->
            <div class="row g-3 mb-4">
                <!-- Search Bar -->
                <div class="col-12 col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent">
                            <i class='bx bx-search'></i>
                        </span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Search bikes..."
                            onkeyup="filterBikes()">
                    </div>
                </div>

                <!-- Brand Filter -->
                <div class="col-12 col-md-2">
                    <select class="form-select" id="brandFilter" onchange="filterBikes()">
                        <option value="">All Brands</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Type Filter -->
                <div class="col-12 col-md-2">
                    <select class="form-select" id="typeFilter" onchange="filterBikes()">
                        <option value="">All Type</option>
                        @foreach ($types as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="col-12 col-md-2">
                    <select class="form-select" id="statusFilter" onchange="filterBikes()">
                        <option value="">All Status</option>
                        <option value="ready">Ready</option>
                        <option value="not_ready">Not Ready</option>
                    </select>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <ul class="nav nav-tabs mb-4" id="bikesTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#allBikes">
                        <i class='bx bx-list-ul'></i> All Bikes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#readyBikes">
                        <i class='bx bx-check-circle'></i> Ready
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#notReadyBikes">
                        <i class='bx bx-x-circle'></i> Not Ready
                    </a>
                </li>
            </ul>

            <!-- Bikes Grid -->
            <div class="tab-content">
                <div class="tab-pane fade show active" id="allBikes">
                    <div id="bikesContainer">
                        @include('backend.rental.bike-grid', ['motor' => $motor])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .transition {
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link {
            color: #697a8d;
            border-bottom: 2px solid transparent;
            cursor: pointer;
        }

        .nav-tabs .nav-link.active {
            color: #696cff;
            border-bottom: 2px solid #696cff;
        }

        .nav-tabs .nav-link:hover {
            border-bottom: 2px solid #696cff;
            color: #696cff;
        }

        #searchInput:focus,
        .form-select:focus {
            border-color: #696cff;
            box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.1);
        }

        .pagination {
            margin: 0;
            display: flex;
            padding-left: 0;
            list-style: none;
            gap: 5px;
        }

        .pagination .page-item .page-link {
            padding: 8px 15px;
            color: #697a8d;
            background-color: #fff;
            border: 1px solid #d9dee3;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }

        .pagination .page-item:not(.disabled) .page-link:hover {
            background-color: #696cff;
            color: #fff;
            border-color: #696cff;
        }

        .pagination .page-item.active .page-link {
            background-color: #696cff;
            color: #fff;
            border-color: #696cff;
        }

        .pagination .page-item.disabled .page-link {
            color: #a5a7ab;
            pointer-events: none;
            background-color: #f0f2f4;
            border-color: #d9dee3;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const bikeId = this.getAttribute('data-id');
                    const form = document.getElementById(`delete-form-${bikeId}`);

                    Swal.fire({
                        title: 'Apa Kamu yakin?',
                        text: "Kamu tidak bisa mengembalikan data ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            let timer;
            const delay = 500;

            function updateURL(params) {
                const url = new URL(window.location);
                Object.entries(params).forEach(([key, value]) => {
                    if (value) {
                        url.searchParams.set(key, value);
                    } else {
                        url.searchParams.delete(key);
                    }
                });
                window.history.pushState({}, '', url);
            }

            function updateActiveTab(status) {
                document.querySelectorAll('#bikesTabs .nav-link').forEach(tab => {
                    tab.classList.remove('active');
                    if ((tab.getAttribute('href') === '#allBikes' && !status) ||
                        (status === 'ready' && tab.getAttribute('href') === '#readyBikes') ||
                        (status === 'not_ready' && tab.getAttribute('href') === '#notReadyBikes')) {
                        tab.classList.add('active');
                    }
                });
            }

            function fetchBikes(page = null) {
                const search = document.getElementById('searchInput').value;
                const brand = document.getElementById('brandFilter').value;
                const type = document.getElementById('typeFilter').value; 
                const status = document.getElementById('statusFilter').value;

                const bikesContainer = document.getElementById('bikesContainer');
                bikesContainer.style.opacity = '0.5';

                const params = new URLSearchParams();
                if (search) params.append('search', search);
                if (brand) params.append('brand', brand);
                if (type) params.append('type', type); 
                if (status) params.append('status', status);
                if (page) params.append('page', page);

                params.append('ajax', 'true');

                fetch(`${window.location.pathname}?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        bikesContainer.innerHTML = html;
                        bikesContainer.style.opacity = '1';
                        updateURL({
                            search,
                            brand,
                            type,
                            status,
                            page
                        });
                        updateActiveTab(status);

                        initializePaginationLinks();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        bikesContainer.style.opacity = '1';
                    });
            }


            function initializePaginationLinks() {
                document.querySelectorAll('.pagination .page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = new URL(this.href).searchParams.get('page');
                        fetchBikes(page);
                    });
                });
            }

            document.getElementById('searchInput').addEventListener('input', (e) => {
                clearTimeout(timer);
                timer = setTimeout(() => fetchBikes(), delay);
            });

            document.getElementById('brandFilter').addEventListener('change', () => fetchBikes());
            document.getElementById('typeFilter').addEventListener('change', () => fetchBikes());
            document.getElementById('statusFilter').addEventListener('change', () => fetchBikes());

            // Tab clicks
            document.querySelectorAll('#bikesTabs .nav-link').forEach(tab => {
                tab.addEventListener('click', (e) => {
                    e.preventDefault();
                    const status = e.target.getAttribute('href') === '#readyBikes' ? 'ready' :
                        e.target.getAttribute('href') === '#notReadyBikes' ? 'not_ready' : '';
                    document.getElementById('statusFilter').value = status;
                    fetchBikes();
                });
            });

            initializePaginationLinks();
        });
    </script>
@endsection
