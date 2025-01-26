@extends('layouts.backend.index')

@section('title', $title)
@section('content')
    <div class="container-fluid mb-5">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }}</h5>
                <form id="filterForm" method="GET" action="{{ route('yearly-report.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Year</label>
                        <select name="year" class="form-select" id="yearSelect">
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8 align-self-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('yearly-report.export-pdf', ['year' => $selectedYear]) }}"
                            class="btn btn-outline-danger">
                            <i class="bx bxs-file-pdf"></i> Export PDF
                        </a>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <canvas id="yearlyChart" height="200"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="yearlyPieChart" height="200"></canvas>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">{{ __('label.income_summary') }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('label.total_transaction') }}</th>
                                                <th>{{ __('label.total_income') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $transactions->count() }}</td>
                                                <td>Rp {{ number_format($transactions->sum('total_amount'), 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">{{ __('label.expense_summary') }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('label.total_service') }}</th>
                                                <th>{{ __('label.total_expense') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $serviceExpenses->count() }}</td>
                                                <td>Rp {{ number_format($serviceExpenses->sum('cost'), 0, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('yearlyChart').getContext('2d');
            var chartData = @json($chartData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.map(item => item.month),
                    datasets: [{
                            label: 'Total Pendapatan',
                            data: chartData.map(item => item.total_amount),
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Total Pengeluaran',
                            data: chartData.map(item => item.total_service_cost),
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y;
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total (Rp)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('yearlyPieChart').getContext('2d');
            var chartData = @json($chartData);

            const totalIncome = chartData.reduce((sum, item) => sum + item.total_amount, 0);
            const totalExpenses = chartData.reduce((sum, item) => sum + item.total_service_cost, 0);

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Pendapatan', 'Pengeluaran'],
                    datasets: [{
                        data: [totalIncome, totalExpenses],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed;
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
