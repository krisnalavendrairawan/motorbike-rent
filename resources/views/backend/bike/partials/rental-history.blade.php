<div class="card-body">
    <h5 class="card-title mb-3" id="rental-history-container">Riwayat Penyewaan</h5>
    @if ($rentalHistory->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal Sewa</th>
                        <th>Customer</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rentalHistory as $rental)
                        <tr>
                            <td>
                                <div class="fw-semibold">
                                    {{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }}
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $rental->customer->name }}</div>
                                <small class="text-muted">{{ $rental->customer->phone }}</small>
                            </td>
                            <td>
                                {{ $rental->duration ?? \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->end_date)) }}
                                hari
                                <small class="d-block text-muted">
                                    {{ \Carbon\Carbon::parse($rental->end_date)->format('d M Y') }}
                                </small>
                            </td>
                            <td>
                                <div class="fw-semibold">
                                    Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-success">Finished</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Rental History Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $rentalHistory->fragment('rental-history')->links('vendor.pagination.custom') }}
        </div>
    @else
        <div class="alert alert-info">
            <i class='bx bx-info-circle me-2'></i>
            Belum ada riwayat penyewaan yang selesai untuk motor ini
        </div>
    @endif
</div>
