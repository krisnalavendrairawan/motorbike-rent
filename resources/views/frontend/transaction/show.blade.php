@extends('frontend.catalog.index')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Transaction Details</h4>
                    </div>
                    <div class="card-body">
                        <!-- Order Info -->
                        <div class="alert alert-info mb-4">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0">Order ID: {{ $transaction->order_id }}</h5>
                                <span
                                    class="badge bg-{{ $transaction->status === 'pending' ? 'warning' : ($transaction->status === 'paid' ? 'success' : 'danger') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </div>
                            <p class="mb-0 text-muted">
                                {{ $transaction->transaction_time ? Carbon\Carbon::parse($transaction->transaction_time)->format('d M Y H:i') : '-' }}
                            </p>
                        </div>

                        <!-- Motor Details -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $transaction->rental->motor->image) }}"
                                    class="img-fluid rounded" alt="{{ $transaction->rental->motor->name }}">
                            </div>
                            <div class="col-md-8">
                                <h5>{{ $transaction->rental->motor->name }}</h5>
                                <p class="text-muted mb-1">{{ $transaction->rental->motor->plate }}</p>
                                <div class="mb-2">
                                    <span class="badge bg-primary">{{ $transaction->rental->motor->brand->name }}</span>
                                    <span class="badge bg-info">{{ $transaction->rental->motor->type }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Rental Details -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Rental Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted">Start Date</p>
                                        <p>{{ $transaction->rental->start_date ? Carbon\Carbon::parse($transaction->rental->start_date)->format('d M Y H:i') : '-' }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted">End Date</p>
                                        <p>{{ $transaction->rental->end_date ? Carbon\Carbon::parse($transaction->rental->end_date)->format('d M Y H:i') : '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Details -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Payment Details</h5>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <p class="mb-1 text-muted">Payment Method</p>
                                        <p class="mb-0 fw-bold text-capitalize">{{ $transaction->payment_type }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-1 text-muted">Total Amount</p>
                                        <p class="mb-0 fw-bold">Rp
                                            {{ number_format($transaction->rental->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                @if ($transaction->status === 'pending')
                                    <div class="card bg-light mb-4">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Payment</h5>
                                            @if ($transaction->snap_token)
                                                <button id="pay-button" class="btn btn-primary">
                                                    Pay Now
                                                </button>
                                            @else
                                                <div class="alert alert-danger">
                                                    Unable to generate payment token
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($transaction->snap_token)
                                        @push('scripts')
                                            <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
                                                data-client-key="{{ config('midtrans.client_key') }}"></script>
                                            <script>
                                                const payButton = document.querySelector('#pay-button');
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
                                            </script>
                                        @endpush
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('transaction.index') }}" class="btn btn-outline-secondary">
                                <i class='bx bx-arrow-back me-2'></i>Back to Transactions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($transaction->status === 'pending')
        @push('scripts')
            <script>
                function checkPaymentStatus() {
                }
            </script>
        @endpush
    @endif
@endsection
