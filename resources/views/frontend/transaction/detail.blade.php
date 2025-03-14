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
                        <!-- Previous motor details section remains the same -->
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

                        <!-- Previous rental details section remains the same -->
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

                        <!-- Modified Actions Section -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">
                                <i class='bx bx-arrow-back me-2'></i>Back
                            </a>
                            @if ($transaction->status === 'pending')
                                @if ($transaction->payment_type === 'cash')
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#paymentInfoModal">
                                        <i class='bx bx-info-circle me-2'></i>Payment Info
                                    </button>
                                @else
                                    @if ($transaction->snap_token)
                                        <button id="pay-button" class="btn btn-primary">
                                            <i class='bx bx-credit-card me-2'></i>Pay Now
                                        </button>
                                    @else
                                        <div class="alert alert-danger">
                                            Unable to generate payment token
                                        </div>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Info Modal for Cash - CORRECTED: changed 'Cash' to 'cash' -->
    @if ($transaction->payment_type === 'cash')
        <div class="modal fade" id="paymentInfoModal" tabindex="-1" aria-labelledby="paymentInfoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentInfoModalLabel">Cash Payment Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-header py-4 text-center bg-light">
                            <div class="app-brand justify-content-center mb-2">
                                <img src="{{ asset('assets/img/illustrations/CS-ilustration.png') }}" alt="Login"
                                    class="auth-illustration" style="width: 200px; height: 200px;">
                            </div>
                            <h4 class="mb-2">Perhatian! 👋</h4>
                        </div>
                        <div class="alert alert-info mb-0">
                            <i class="bx bx-info-circle me-2"></i>
                            Anda membayar Cash, Silakan lakukan pembayaran di lokasi kami. Staff kami akan membantu Anda
                            dalam proses pembayaran.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
@if ($transaction->status === 'pending' && $transaction->payment_type !== 'cash')
    @push('scripts')
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            const payButton = document.querySelector('#pay-button');
            if (payButton) { // Add this check
                payButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Token:', '{{ $transaction->snap_token }}');
                    snap.pay('{{ $transaction->snap_token }}', {
                        onSuccess: function(result) {
                            fetch(`/transaction/${result.order_id}/update-status`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            .content
                                    },
                                    body: JSON.stringify({
                                        status: 'success',
                                        result: result
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        window.location.href = '{{ route('transaction.index') }}';
                                    } else {
                                        alert('Error updating payment status');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Error updating payment status');
                                });
                        },
                    });
                });
            }
        </script>
    @endpush
@endif