@extends('layouts.backend.index')

@section('title', "Detail {$motor->name}")

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('bike.index') }}">{{ __('label.bikes') }}</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ $motor->name }}</li>
@endsection

@section('page-action')
    <li class="breadcrumb-item text-light">
        <x-profile />
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Card Motor Image -->
            <div class="col-12 col-lg-6">
                <div class="card card-motor">
                    <div class="card-image-wrapper" style="height: 550px;">
                        <img src="{{ asset('storage/' . $motor->image) }}" alt="{{ $motor->name }}" class="card-img">
                        <div class="status-badge">
                            <span class="badge bg-{{ $motor->status === 'ready' ? 'success' : 'danger' }} fs-6">
                                {{ $motor->status === 'ready' ? 'Ready' : 'Not Ready' }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <a href="{{ route('bike.edit', $motor->id) }}" class="btn btn-primary flex-grow-1">
                                <i class='bx bxs-edit me-2'></i> Edit Motor
                            </a>
                            <a href="{{ route('bike.index') }}" class="btn btn-outline-secondary">
                                <i class='bx bx-arrow-back me-2'></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Perawatan (Separated) -->
                <div class="card mt-3" id="service-history">
                    @include('backend.bike.partials.service-history', [
                        'serviceHistory' => $serviceHistory,
                    ])
                </div>
            </div>


            <!-- Detail Informasi -->
            <div class="col-12 col-lg-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title mb-4">{{ $motor->name }}</h3>
                        <div class="row g-3">
                            <!-- Plat Nomor -->
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-3 rounded-3" style="min-width: 100px;">
                                        <i class='bx bxs-badge fs-4'></i>
                                    </div>
                                    <div class="ms-3">
                                        <small class="text-muted d-block">Plat Nomor</small>
                                        <span class="fs-5 fw-semibold">{{ $motor->plate }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Brand -->
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-3 rounded-3" style="min-width: 100px;">
                                        <i class='bx bxs-trophy fs-4'></i>
                                    </div>
                                    <div class="ms-3">
                                        <small class="text-muted d-block">Brand</small>
                                        <span class="fs-5 fw-semibold">{{ $motor->brand->name }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tipe -->
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-3 rounded-3" style="min-width: 100px;">
                                        <i class='bx bxs-category fs-4'></i>
                                    </div>
                                    <div class="ms-3">
                                        <small class="text-muted d-block">Tipe</small>
                                        <span class="fs-5 fw-semibold">{{ $motor->type }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Warna -->
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-3 rounded-3" style="min-width: 100px;">
                                        <i class='bx bxs-color-fill fs-4'></i>
                                    </div>
                                    <div class="ms-3">
                                        <small class="text-muted d-block">Warna</small>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="d-inline-block rounded-circle"
                                                style="width: 20px; height: 20px; background-color: {{ $motor->color }}">
                                            </span>
                                            <span class="fs-5 fw-semibold">{{ $motor->color }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Harga -->
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-3 rounded-3" style="min-width: 100px;">
                                        <i class='bx bx-money fs-4'></i>
                                    </div>
                                    <div class="ms-3">
                                        <small class="text-muted d-block">Harga Sewa / Hari</small>
                                        <span class="fs-5 fw-semibold">Rp
                                            {{ number_format($motor->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="col-12 mt-4">
                                <h5 class="mb-3">Deskripsi</h5>
                                <p class="text-muted">{{ $motor->description ?: 'Tidak ada deskripsi' }}</p>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Riwayat Penyewaan (Separated) -->
                <div class="card mb-4" id="rental-history">
                    @include('backend.bike.partials.rental-history', [
                        'rentalHistory' => $rentalHistory,
                    ])
                </div>
            </div>
        </div>
    </div>


@endsection

@push('styles')
    <style>
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1);
        }

        /* Motor Card Specific Styles */
        .card-motor {
            background: #fff;
        }

        .card-image-wrapper {
            position: relative;
            height: 400px;
            overflow: hidden;
        }

        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.3s ease;
        }

        .card-motor:hover .card-img {
            transform: scale(1.05);
        }

        .status-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 2;
        }

        .status-badge .badge {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        }

        /* Button Styles */
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn i {
            font-size: 1.1rem;
        }

        /* Info Card Styles */
        .bg-light {
            background-color: #f8f9fa !important;
        }

        .rounded-3 {
            border-radius: 1rem !important;
        }

        /* Table Styles */
        .rental-history {
            margin-top: 2rem;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            padding: 1rem;
            border-bottom: 2px solid #e9ecef;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .table tr:hover {
            background-color: #f8f9fa;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .card-image-wrapper {
                height: 300px;
            }
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
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setupAjaxPagination(containerSelector, fragmentId) {
                const container = document.querySelector(containerSelector);

                container.addEventListener('click', function(e) {
                    const pageLink = e.target.closest('.page-link');

                    if (pageLink && !pageLink.closest('.disabled')) {
                        e.preventDefault();

                        const url = pageLink.getAttribute('href');

                        fetch(url, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newContent = doc.querySelector(containerSelector);

                                if (newContent) {
                                    container.innerHTML = newContent.innerHTML;

                                    // Update URL without page reload
                                    history.pushState(null, '', url);

                                    // Re-attach event listeners if needed
                                    setupAjaxPagination(containerSelector, fragmentId);
                                }
                            })
                            .catch(error => {
                                console.error('Pagination error:', error);
                            });
                    }
                });
            }

            // Setup for Rental History
            setupAjaxPagination('#rental-history', 'rental-history');

            // Setup for Service History
            setupAjaxPagination('#service-history', 'service-history');
        });
    </script>
@endpush
