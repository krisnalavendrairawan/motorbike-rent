@extends('layouts.backend.index')

@section('title', $title)

@section('breadcrumb')
    {{-- <li class="breadcrumb-item active" aria-current="page"></li> --}}
@endsection

@section('page-action')
    <x-profile />
@endsection

@section('content')
    @push('styles')
        <style>
            .page-title-box {
                background: #fff;
                padding: 1.5rem;
                border-radius: 0.375rem;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            }

            .breadcrumb-item+.breadcrumb-item::before {
                color: #6c757d;
            }

            .breadcrumb-item a {
                color: #6c757d;
                text-decoration: none;
            }

            .breadcrumb-item.active {
                color: #495057;
            }
        </style>
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-8 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Welcome {{ $user->name }}! 🎉</h5>
                                    <p class="mb-4">
                                        You have access to {{ $motorCount }} motors and {{ $brandCount }} brands in the
                                        system.
                                    </p>

                                    <a href="{{ route('bike.index') }}" class="btn btn-sm btn-outline-primary">View</a>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                                        alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 order-1">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                                class="rounded" />
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Total Motors</span>
                                    <h3 class="card-title mb-2">{{ $motorCount }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="../assets/img/icons/unicons/wallet-info.png" alt="Credit Card"
                                                class="rounded" />
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Total Brands</span>
                                    <h3 class="card-title mb-2">{{ $brandCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Total Revenue -->
                <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                    <div class="card">
                        <div class="row row-bordered g-0">
                            <div class="col-md-8">
                                <h5 class="card-header m-0 me-2 pb-3">Monthly Revenue {{ now()->year }}</h5>
                                <div class="px-2">
                                    <canvas id="revenueChart" height="200"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h4>Total Revenue {{ now()->year }}</h4>
                                        <h2 class="mb-2">Rp {{ number_format($yearlyRevenue, 0, ',', '.') }}</h2>
                                    </div>

                                    <div class="mt-4">
                                        <h6>Monthly Growth</h6>
                                        <div class="d-flex align-items-center">
                                            <h3 class="mb-0 me-2">{{ number_format($monthlyGrowth, 1) }}%</h3>
                                            @if ($monthlyGrowth > 0)
                                                <i class='bx bx-trending-up text-success'></i>
                                            @elseif($monthlyGrowth < 0)
                                                <i class='bx bx-trending-down text-danger'></i>
                                            @else
                                                <i class='bx bx-minus text-warning'></i>
                                            @endif
                                        </div>
                                        <small class="text-muted">Compared to last month</small>
                                    </div>

                                    <div class="mt-4">
                                        <h6>Current Month Revenue</h6>
                                        <h4>Rp {{ number_format($currentMonthRevenue, 0, ',', '.') }}</h4>
                                        <small class="text-muted">{{ now()->format('F Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Total Revenue -->
                <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                    <div class="row">
                        <div class="col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="../assets/img/icons/unicons/chart.png" alt="Monthly Rentals"
                                                class="rounded" />
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="d-block mb-1">Monthly Rentals</span>
                                    <h3 class="card-title text-nowrap mb-2">{{ $currentMonthRentals }}</h3>
                                    <small class="text-muted">For {{ now()->format('F Y') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="../assets/img/icons/unicons/cc-primary.png" alt="Staff Users"
                                                class="rounded" />
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Staff Users</span>
                                    <h3 class="card-title mb-2">{{ $staffCount }}</h3>
                                    <small class="text-muted">Total Staff Users</small>
                                </div>
                            </div>
                        </div>
                        <!-- </div>
                                                                                                                                <div class="row"> -->
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                            <div class="card-title">
                                                <h5 class="text-nowrap mb-2">Monthly Income Report</h5>
                                                <span
                                                    class="badge bg-label-warning rounded-pill">{{ now()->format('F Y') }}</span>
                                            </div>
                                            <div class="mt-sm-auto">
                                                <h3 class="mb-0">Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</h3>
                                                <small class="text-success text-nowrap fw-semibold">
                                                    <i class="bx bxs-vector"></i>
                                                    {{ $currentMonthRentals }} rentals this month
                                                </small>
                                            </div>
                                        </div>
                                        <div id="profileReportChart" style="min-height: 80px; min-width: 80px;">
                                            <span class="text-primary" style="font-size: 3em;">
                                                <i class="bx bx-money"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Order Statistics -->
                <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between pb-0">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Top Performing Motors</h5>
                                <small class="text-muted">Based on total revenue</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <h2 class="mb-2">{{ number_format($topMotors->sum('rental_count')) }}</h2>
                                    <span>Total Rentals</span>
                                </div>
                            </div>
                            <ul class="p-0 m-0">
                                @foreach ($topMotors as $motor)
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-primary">
                                                <i class="bx bx-motorcycle"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">{{ $motor->motor_name }}</h6>
                                                <small class="text-muted">{{ $motor->brand_name }}</small>
                                            </div>
                                            <div class="user-progress">
                                                <small class="fw-semibold">Rp
                                                    {{ number_format($motor->total_revenue, 0, ',', '.') }}</small>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/ Order Statistics -->

                <!-- Expense Overview -->
                <div class="col-md-6 col-lg-4 order-1 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title m-0 me-2">Service Overview</h5>
                        </div>
                        <div class="card-body px-0">
                            <div class="tab-content p-0">
                                <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                                    <div class="d-flex p-4 pt-3">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <img src="../assets/img/icons/unicons/wallet.png" alt="User" />
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Total Service Expenses</small>
                                            <div class="d-flex align-items-center">
                                                <h6 class="mb-0 me-1">Rp
                                                    {{ number_format($totalServiceExpenses, 0, ',', '.') }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4">
                                        <h6 class="mb-3">Motors In Service</h6>
                                        <ul class="p-0 m-0">
                                            @foreach ($motorsInService as $service)
                                                <li class="d-flex mb-3">
                                                    <div class="avatar flex-shrink-0 me-3">
                                                        <span class="avatar-initial rounded bg-label-primary">
                                                            <i class="bx bx-wrench"></i>
                                                        </span>
                                                    </div>
                                                    <div
                                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                        <div class="me-2">
                                                            <h6 class="mb-0">{{ $service->motor->name }}</h6>
                                                            <small
                                                                class="text-muted">{{ \Carbon\Carbon::parse($service->service_date)->format('d M Y') }}</small>
                                                        </div>
                                                        <div class="user-progress">
                                                            <small class="fw-semibold">Rp
                                                                {{ number_format($service->cost, 0, ',', '.') }}</small>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Expense Overview -->

                <!-- Transactions -->
                <!-- Recent Rentals -->
                <div class="col-md-6 col-lg-4 order-2 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Recent Rentals</h5>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                    <a class="dropdown-item" href="{{ route('list.rental') }}">View All Rentals</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="p-0 m-0">
                                @foreach ($latestRentals as $rental)
                                    @php
                                        $startDate = \Carbon\Carbon::parse($rental->start_date);
                                        $endDate = \Carbon\Carbon::parse($rental->end_date);
                                        $days = $startDate->diffInDays($endDate) + 1;
                                    @endphp
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-primary">
                                                <i class="bx bx-user"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-muted d-block mb-1">{{ $days }} days rental</small>
                                                <h6 class="mb-0">{{ $rental->customer->name }}</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0">{{ number_format($rental->total_price, 0, ',', '.') }}</h6>
                                                <span class="text-muted">IDR</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/ Recent Rentals -->
                <!--/ Transactions -->
            </div>
        </div>
        {{-- @if (session()->has('success'))
            <script>
                $(document).ready(function() {
                    setNotifSuccess("{{ session()->get('success') }}", false)
                })
            </script>
        @endif --}}
    @endsection
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @if (session('success'))
            <script>
                @if (session('success'))
                    <
                    script >
                        $(document).ready(function() {
                            setNotifSuccess("{{ session('success') }}", false);
                        }); <
                    />
                @endif
            </script>
        @endif
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById('revenueChart').getContext('2d');

                const monthlyData = @json($monthlyRevenue);

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: monthlyData.map(item => item.month),
                        datasets: [{
                            label: 'Monthly Revenue',
                            data: monthlyData.map(item => item.revenue),
                            backgroundColor: '#696cff',
                            borderColor: '#696cff',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                            ".");
                                    }
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Revenue: Rp ' + context.raw.toString().replace(
                                            /\B(?=(\d{3})+(?!\d))/g, ".");
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
