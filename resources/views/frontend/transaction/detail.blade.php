@extends('frontend.catalog.index')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0 overflow-hidden">
                    <div class="card-header bg-warning text-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-1">Order #{{ $transaction->order_id }}</h4>
                                <p class="mb-0 opacity-75">
                                    {{ Carbon\Carbon::parse($transaction->created_at)->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <span
                                class="badge bg-{{ $transaction->status === 'pending' ? 'warning' : ($transaction->status === 'paid' ? 'success' : 'danger') }} p-2">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $transaction->rental->motor->image) }}"
                                    class="img-fluid rounded shadow-sm" alt="{{ $transaction->rental->motor->name }}">
                            </div>
                            <div class="col-md-8">
                                <h5 class="card-title">{{ $transaction->rental->motor->name }}</h5>
                                <div class="mb-3">
                                    <span class="badge bg-primary">{{ $transaction->rental->motor->brand->name }}</span>
                                    <span class="badge bg-info">{{ $transaction->rental->motor->type }}</span>
                                </div>
                                <div class="list-group">
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ __('label.plate') }}</span>
                                        <strong>{{ $transaction->rental->motor->plate }}</strong>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ __('label.color') }}</span>
                                        <strong>{{ $transaction->rental->motor->color }}</strong>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Daily Rate</span>
                                        <strong>Rp
                                            {{ number_format($transaction->rental->motor->price, 0, ',', '.') }}/day</strong>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Lama rental</span>
                                        <strong>
                                            {{ Carbon\Carbon::parse($transaction->rental->start_date)->diffInDays(Carbon\Carbon::parse($transaction->rental->end_date)) }}
                                            Hari
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rental Details -->
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title text-muted mb-3">Rental Period</h6>
                                        <div class="d-flex justify-content-between mb-2">
                                            <div>
                                                <small class="text-muted d-block">{{ __('label.start_date') }}</small>
                                                <strong>{{ Carbon\Carbon::parse($transaction->rental->start_date)->format('d M Y, H:i') }}</strong>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">{{ __('label.end_date') }}</small>
                                                <strong>{{ Carbon\Carbon::parse($transaction->rental->end_date)->format('d M Y, H:i') }}</strong>
                                            </div>
                                        </div>
                                        <div class="progress mt-2" style="height: 4px;">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title text-muted mb-3">Payment Information</h6>
                                        <div class="list-group">
                                            <div
                                                class="list-group-item bg-transparent border-0 px-0 py-1 d-flex justify-content-between">
                                                <span>Payment Method</span>
                                                <strong class="text-capitalize">{{ $transaction->payment_type }}</strong>
                                            </div>
                                            <div
                                                class="list-group-item bg-transparent border-0 px-0 py-1 d-flex justify-content-between">
                                                <span>Total Amount</span>
                                                <strong class="text-primary">Rp
                                                    {{ number_format($transaction->rental->total_price, 0, ',', '.') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">
                                <i class='bx bx-arrow-back me-2'></i>Back
                            </a>
                            @if ($transaction->status === 'pending')
                                <button class="btn btn-primary">
                                    <i class='bx bx-credit-card me-2'></i>Pay Now
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #696cff 0%, #4844ff 100%);
        }

        .card {
            transition: transform 0.2s;
        }

        @media (max-width: 768px) {
            .card-title {
                font-size: 1.1rem;
            }

            .badge {
                font-size: 0.7rem;
            }
        }
    </style>
@endpush
