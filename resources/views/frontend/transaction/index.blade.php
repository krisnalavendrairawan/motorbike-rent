@extends('frontend.catalog.index')

@section('content')
    <div class="container py-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-warning text-white">
                <h4 class="mb-0">My Transactions</h4>
            </div>
            <div class="card-body">
                @if ($transactions->isEmpty())
                    <div class="text-center py-5">
                        <i class='bx bx-receipt fs-1 text-muted'></i>
                        <p class="mt-3">No transactions found</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('label.no') }}</th>
                                    <th>Order ID</th>
                                    <th>Motor</th>
                                    <th>Rental Period</th>
                                    <th>Total Price</th>
                                    <th>Tipe Pembayaran</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transaction->order_id }}</td>
                                        <td>{{ $transaction->rental->motor->name }}</td>
                                        <td>
                                            {{ $transaction->rental->start_date ? Carbon\Carbon::parse($transaction->rental->start_date)->format('d M Y H:i') : '-' }}
                                            -
                                            {{ $transaction->rental->end_date ? Carbon\Carbon::parse($transaction->rental->end_date)->format('d M Y H:i') : '-' }}

                                        </td>
                                        <td>Rp {{ number_format($transaction->rental->total_price, 0, ',', '.') }}</td>
                                        </td>
                                        <td>{{ $transaction->payment_type }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $transaction->status === 'pending' ? 'warning' : ($transaction->status === 'paid' ? 'success' : 'danger') }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('transaction.detail', $transaction->id) }}"
                                                    class="btn btn-sm btn-info text-white">
                                                    <i class='bx bx-detail'></i> Detail
                                                </a>
                                                @if (
                                                    ($transaction->status === 'pending' && $transaction->payment_type === 'qris') ||
                                                        ($transaction->status === 'pending' && $transaction->payment_type === 'Transfer'))
                                                    <a href="{{ route('transaction.show', $transaction->id) }}"
                                                        class="btn btn-sm btn-primary mx-2">
                                                        <i class='bx bx-credit-card'></i> Pay
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $transactions->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-container {
            flex: 1;
        }
    </style>
@endpush
