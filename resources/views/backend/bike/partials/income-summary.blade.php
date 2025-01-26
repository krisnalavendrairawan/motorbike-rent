            {{-- Total Income & Expense --}}
            <div class="col-12 mt-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title">Ringkasan Keuangan dari motor <span
                                    class="text-info">{{ $motor->name }}</span></h4>
                            <form method="get" class="d-flex align-items-center">
                                <select name="year" class="form-select form-select-sm me-2" style="width: 100px;"
                                    onchange="this.form.submit()">
                                    @foreach ($availableYears as $availableYear)
                                        <option value="{{ $availableYear }}"
                                            {{ $selectedYear == $availableYear ? 'selected' : '' }}>
                                            {{ $availableYear }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-primary text-white mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title text-white">Total Pendapatan</h5>
                                        <p class="card-text fs-4">
                                            Rp {{ number_format($totalRentalIncome, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-danger text-white mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title text-white">Total Pengeluaran</h5>
                                        <p class="card-text fs-4">
                                            Rp {{ number_format($totalServiceExpenses, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-success text-white mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title text-white">Keuntungan Bersih</h5>
                                        <p class="card-text fs-4">
                                            Rp
                                            {{ number_format($totalRentalIncome - $totalServiceExpenses, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
