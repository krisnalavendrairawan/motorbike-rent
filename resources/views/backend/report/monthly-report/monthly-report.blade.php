@extends('layouts.backend.index')

@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('page-action')
    <li class="breadcrumb-item text-light position static">
        <x-profile />
    </li>
@endsection
@section('content')
    <div class="container-fluid mb-5">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }}</h5>
                <form id="filterForm" method="GET" action="{{ route('monthly-report.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Month</label>
                        <select name="month" class="form-select" id="monthSelect">
                            @foreach (range(1, 12) as $month)
                                <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>
                                    {{ __('label.' . strtolower(date('F', mktime(0, 0, 0, $month)))) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
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
                    <div class="col-md-4 align-self-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('monthly-report.export-pdf', ['month' => $selectedMonth, 'year' => $selectedYear]) }}"
                            class="btn btn-outline-danger">
                            <i class="bx bxs-file-pdf"></i> Export PDF
                        </a>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-12">
                        <canvas id="transactionChart" height="100"></canvas>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {{-- Income Summary --}}
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
                                                <td>{{ $transactions->total() }}</td>
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
                        {{-- Expense Summary --}}
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
                                                <td>{{ $serviceExpenses->total() }}</td>
                                                <td>Rp {{ number_format($serviceExpenses->sum('cost'), 0, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Detail Pendapatan Perbulan</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Motor</th>
                                                <th>{{ __('label.total_income') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="transaction-table-body">
                                            @foreach ($transactions as $transaction)
                                                <tr>
                                                    <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                                    <td>{{ $transaction->rental->motor->name ?? 'N/A' }}</td>
                                                    <td>Rp
                                                        {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <ul id="transaction-pagination" class="pagination">
                                        {{ $transactions->appends(request()->input())->links('backend.report.monthly-report.vendor.pagination') }}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Detail Pengeluaran Perbulan</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Motor</th>
                                                <th>Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody id="service-table-body">
                                            @foreach ($serviceExpenses as $service)
                                                <tr>
                                                    <td>{{ Carbon\Carbon::parse($service->service_date)->format('d M Y') }}
                                                    </td>
                                                    <td>{{ $service->motor->name ?? 'N/A' }}</td>
                                                    <td>Rp {{ number_format($service->cost, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <ul id="service-pagination" class="pagination">
                                        {{ $serviceExpenses->appends(request()->input())->links('backend.report.monthly-report.vendor.pagination') }}
                                    </ul>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('transactionChart').getContext('2d');
            var chartData = @json($chartData);
            // console.log('Chart Data:', chartData);
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.map(item => item.day),
                    datasets: [{
                            label: 'Total Pendapatan',
                            data: chartData.map(item => item.total_amount),
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Total Pengeluaran',
                            data: chartData.map(item => item.total_service_cost),
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
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
                                text: 'Date'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Pendapatan (Rp)'
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

            const selectedMonth = '{{ $selectedMonth }}';
            const selectedYear = '{{ $selectedYear }}';

            // Transaction Pagination
            $(document).on('click', '#transaction-pagination .page-link', function(e) {
                e.preventDefault();
                const page = $(this).text();
                $.ajax({
                    url: '{{ route('monthly-report.transaction-pagination') }}',
                    method: 'GET',
                    data: {
                        page: page,
                        month: selectedMonth,
                        year: selectedYear
                    },
                    success: function(response) {
                        $('#transaction-table-body').html(response.html);
                        updatePagination('#transaction-pagination', response.last_page, page);
                    }
                });
            });

            // Service Pagination
            $(document).on('click', '#service-pagination .page-link', function(e) {
                e.preventDefault();
                const page = $(this).text();
                console.log('Service pagination clicked', page); // Add this line
                $.ajax({
                    url: '{{ route('monthly-report.service-pagination') }}',
                    method: 'GET',
                    data: {
                        page: page,
                        month: selectedMonth,
                        year: selectedYear
                    },
                    success: function(response) {
                        console.log('Service pagination response', response); // Add this line
                        $('#service-table-body').html(response.html);
                        updatePagination('#service-pagination', response.last_page, page);
                    },
                    error: function(xhr, status, error) {
                        console.error('Service pagination error', error); // Add this line
                    }
                });
            });

            function updatePagination(selector, lastPage, currentPage) {
                const $pagination = $(selector);
                $pagination.find('.page-item').removeClass('active disabled');
                $pagination.find('.page-link').each(function() {
                    const pageNum = $(this).text();
                    if (pageNum == currentPage) {
                        $(this).closest('.page-item').addClass('active');
                    }
                    if (pageNum > lastPage) {
                        $(this).closest('.page-item').addClass('disabled');
                    }
                });
            }
        });
    </script>
@endpush
