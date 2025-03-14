@extends('layouts.backend.index')

@section('title', 'Create New Rental')
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('rental.index') }}">{{ __('label.rental') }}</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Create New Rental</li>
@endsection

@section('page-action')
    <li class="breadcrumb-item text-light">
        <x-profile />
    </li>
@endsection
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Rental Information</h5>

                        <form action="{{ route('rental.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="motor_id" value="{{ $motor->id }}">

                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label">Customer</label>
                                    <select name="customer_id"
                                        class="form-select @error('customer_id') is-invalid @enderror" required>
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} - {{ $customer->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Start Date</label>
                                    <input type="datetime-local" name="start_date"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        value="{{ old('start_date') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">End Date</label>
                                    <input type="datetime-local" name="end_date"
                                        class="form-control @error('end_date') is-invalid @enderror"
                                        value="{{ old('end_date') }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Total Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="total_price" id="total_price"
                                            class="form-control @error('total_price') is-invalid @enderror"
                                            value="{{ old('total_price') }}" readonly>
                                        @error('total_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">{{ __('string.auto_total_price') }}</small>
                                </div>
                                <div class="col-12">
                                    <select name="payment_type" hidden
                                        class="form-select @error('payment_type') is-invalid @enderror" required>
                                        <option value="cash" selected>cash</option>
                                    </select>
                                    @error('payment_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Additional Notes</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3"
                                        placeholder="Any special requirements or notes...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class='bx bxs-save'></i> Create Rental
                                        </button>
                                        <a href="{{ route('rental.index') }}" class="btn btn-outline-secondary">
                                            <i class='bx bx-x'></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Bike Information Card -->
            <div class="col-12 col-lg-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $motor->image) }}" class="card-img-top" alt="{{ $motor->name }}"
                        style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ $motor->name }}</h5>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-primary">{{ $motor->brand->name }}</span>
                            <span class="badge bg-info">{{ $motor->type }}</span>
                            <span class="badge" style="background-color: {{ $motor->color }}">
                                {{ $motor->color }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Plate Number</small>
                            <span class="fs-6 fw-semibold">{{ $motor->plate }}</span>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Daily Rate</small>
                            <span class="fs-5 fw-bold text-primary">
                                Rp {{ number_format($motor->price, 0, ',', '.') }}
                            </span>
                        </div>

                        @if ($motor->description)
                            <div class="mb-3">
                                <small class="text-muted d-block">Description</small>
                                <p class="mb-0">{{ $motor->description }}</p>
                            </div>
                        @endif
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

        .form-control:focus,
        .form-select:focus {
            border-color: #696cff;
            box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.1);
        }

        .btn-primary {
            background-color: #696cff;
            border-color: #696cff;
        }

        .btn-primary:hover {
            background-color: #5f65e8;
            border-color: #5f65e8;
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const startDateInput = document.querySelector('input[name="start_date"]');
                const endDateInput = document.querySelector('input[name="end_date"]');
                const totalPriceInput = document.getElementById('total_price');
                const dailyRate = {{ $motor->price }};

                function calculateTotalPrice() {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(endDateInput.value);

                    if (startDate && endDate && startDate < endDate) {
                        const diffTime = Math.abs(endDate - startDate);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                        const totalPrice = diffDays * dailyRate;
                        totalPriceInput.value = totalPrice;
                    } else {
                        totalPriceInput.value = '';
                    }
                }

                startDateInput.addEventListener('change', calculateTotalPrice);
                endDateInput.addEventListener('change', calculateTotalPrice);
            });
        </script>
    @endpush
@endsection
