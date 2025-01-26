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
                            <a href="{{ route('bike.index') }}" class="btn btn-outline-secondary">
                                <i class='bx bx-arrow-back me-2'></i> Kembali
                            </a>
                        </div>
                    </div>
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

                <!-- Riwayat Penyewaan -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Riwayat Penyewaan</h5>
                        <div class="alert alert-info">
                            <i class='bx bx-info-circle me-2'></i>
                            Fitur riwayat penyewaan akan segera hadir
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>

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
    </style>
@endsection
