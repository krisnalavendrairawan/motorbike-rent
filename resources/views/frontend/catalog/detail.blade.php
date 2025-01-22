@extends('frontend.catalog.index')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-12 col-lg-6 mb-4">
                <div class="card">
                    <div class="position-relative">
                        @php
                            $isPNG = pathinfo($motor->image, PATHINFO_EXTENSION) === 'png';
                        @endphp
                        <div class="{{ $isPNG ? 'p-4' : '' }}">
                            <img src="{{ asset('storage/' . $motor->image) }}" alt="{{ $motor->name }}"
                                class="card-img-top {{ $isPNG ? 'p-2' : '' }}"
                                style="height: 500px; object-fit: {{ $isPNG ? 'contain' : 'cover' }};">
                        </div>
                        <div class="position-absolute top-0 end-0 p-3">
                            <span class="badge bg-{{ $motor->status === 'ready' ? 'success' : 'danger' }} fs-6">
                                {{ $motor->status === 'ready' ? 'Ready' : 'Not Ready' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>



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

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <!-- Tombol Kembali -->
                            <a href="javascript:history.back()" class="btn btn-outline-danger">
                                <i class='bx bx-arrow-back me-2'></i>Kembali
                            </a>
                            <!-- Tombol Rental Sekarang -->
                            <a href="{{ route('customer.rental', $motor->id) }}" class="btn btn-outline-primary">
                                <i class='bx bx-bookmark-plus me-2'></i>Rental Sekarang
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .card {
            border: none;
            box-shadow: 0 0 0.875rem 0 rgba(33, 37, 41, .05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem rgba(33, 37, 41, .1);
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .rounded-3 {
            border-radius: 0.5rem !important;
        }

        .bx {
            color: #696cff;
        }
    </style>
@endsection
