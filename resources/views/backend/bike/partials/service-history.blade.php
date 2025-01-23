                <!-- Riwayat Perawatan (Separated) -->
                <div class="card mt-3" id="service-history">
                    <div class="card-body">
                        <h5 class="card-title mb-3" id="service-history-container">Riwayat Perawatan</h5>
                        @if ($serviceHistory->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jenis Perawatan</th>
                                            <th>Total Biaya</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($serviceHistory as $service)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($service->service_date)->format('d M Y') }}
                                                </td>
                                                <td>{{ $service->service_type }}</td>
                                                <td>Rp {{ number_format($service->cost, 0, ',', '.') }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $service->status == 'completed' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($service->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Service History Pagination -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $serviceHistory->fragment('service-history')->links('vendor.pagination.custom') }}
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class='bx bx-info-circle me-2'></i>
                                Belum ada riwayat perawatan untuk motor ini
                            </div>
                        @endif
                    </div>
                </div>