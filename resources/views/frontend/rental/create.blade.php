@extends('frontend.catalog.index')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Book Your Motorcycle</h2>

                        <!-- Customer Information -->
                        <div class="alert alert-info d-flex align-items-center mb-4">
                            <i class='bx bxs-user-circle fs-4 me-2'></i>
                            <div>
                                <strong>Customer Details:</strong><br>
                                Name: {{ auth()->user()->name }}<br>
                                Email: {{ auth()->user()->email }}
                            </div>
                        </div>

                        <!-- Motor Details Section -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $motor->image) }}" class="img-fluid rounded"
                                    alt="{{ $motor->name }}"
                                    style="object-fit: {{ pathinfo($motor->image, PATHINFO_EXTENSION) === 'png' ? 'contain' : 'cover' }};">
                            </div>
                            <div class="col-md-8">
                                <h4 class="mb-2">{{ $motor->name }}</h4>
                                <p class="text-muted mb-1"><i class='bx bxs-badge'></i> {{ $motor->plate }}</p>
                                <div class="mb-2">
                                    <span class="badge bg-primary">{{ $motor->brand->name }}</span>
                                    <span class="badge bg-info">{{ $motor->type }}</span>
                                    <span class="badge"
                                        style="background-color: {{ $motor->color }}">{{ $motor->color }}</span>
                                </div>
                                <h5 class="text-primary">Rp {{ number_format($motor->price, 0, ',', '.') }} / Day</h5>
                            </div>
                        </div>

                        <!-- Rental Form -->
                        <form action="{{ route('customer.rental.store') }}" method="POST" id="rentalForm">
                            @csrf
                            <input type="hidden" name="motor_id" value="{{ $motor->id }}">
                            <input type="hidden" name="customer_id" value="{{ auth()->id() }}">
                            <input type="hidden" name="total_price" id="totalPrice">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Start Date</label>
                                        <input type="datetime-local"
                                            class="form-control @error('start_date') is-invalid @enderror" name="start_date"
                                            id="startDate" min="{{ date('Y-m-d\TH:i') }}" required>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">End Date</label>
                                        <input type="datetime-local"
                                            class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                                            id="endDate" required>
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('label.payment_type') }}</label>
                                        <div class="row g-3">
                                            @foreach ($payment_type as $type)
                                                <div class="col-md-4">
                                                    <div class="form-check payment-type-card">
                                                        <input class="form-check-input" type="radio" name="payment_type"
                                                            id="payment_{{ $type }}" value="{{ $type }}"
                                                            required>
                                                        <label class="form-check-label payment-type-label"
                                                            for="payment_{{ $type }}">
                                                            <i
                                                                class='bx bx-{{ $type === 'cash' ? 'money' : ($type === 'transfer' ? 'transfer' : 'qr') }} fs-4'></i>
                                                            <span class="ms-2 text-capitalize">{{ $type }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('payment_type')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Additional Notes</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3"
                                            placeholder="Any special requests or notes..."></textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h5 class="card-title">Rental Summary</h5>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Customer:</span>
                                                <span>{{ auth()->user()->name }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Duration:</span>
                                                <span id="duration">-</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Rate per Day:</span>
                                                <span>Rp {{ number_format($motor->price, 0, ',', '.') }}</span>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between fw-bold">
                                                <span>Total Price:</span>
                                                <span id="displayPrice">-</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 text-center mt-4">
                                    <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary btn-lg me-2">
                                        <i class='bx bx-arrow-back me-2'></i>Back
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class='bx bxs-calendar-check me-2'></i>Confirm Booking
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            const durationElement = document.getElementById('duration');
            const displayPriceElement = document.getElementById('displayPrice');
            const totalPriceInput = document.getElementById('totalPrice');
            const dailyRate = {{ $motor->price }};

            function updateDurationAndPrice() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (startDate && endDate && startDate < endDate) {
                    const diffTime = Math.abs(endDate - startDate);
                    let days = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    days = Math.max(1, days); 

                    const totalPrice = days * dailyRate;

                    durationElement.textContent = days + (days === 1 ? ' day' : ' days');
                    displayPriceElement.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
                    totalPriceInput.value = totalPrice;

                    // Update end date min attribute
                    endDateInput.min = startDateInput.value;
                } else {
                    durationElement.textContent = '-';
                    displayPriceElement.textContent = '-';
                    totalPriceInput.value = '';
                }
            }

            startDateInput.addEventListener('change', updateDurationAndPrice);
            endDateInput.addEventListener('change', updateDurationAndPrice);

            // Set initial min values
            const now = new Date();
            startDateInput.min = now.toISOString().slice(0, 16);
            if (startDateInput.value) {
                endDateInput.min = startDateInput.value;
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .card {
            border-radius: 15px;
            transition: transform 0.3s ease;
        }

        .btn {
            border-radius: 50px;
            padding: 10px 30px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            box-shadow: 0 5px 15px rgba(105, 108, 255, 0.4);
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
        }

        .badge {
            padding: 8px 15px;
            border-radius: 50px;
        }

        .alert {
            border-radius: 12px;
        }

        .payment-type-card {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .payment-type-card:hover {
            border-color: #696cff;
            background-color: #f8f9fa;
        }

        .payment-type-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            margin-bottom: 0;
        }

        .form-check-input:checked+.payment-type-label {
            color: #696cff;
        }

        .form-check-input:checked+.payment-type-label i {
            color: #696cff;
        }
    </style>
@endpush
