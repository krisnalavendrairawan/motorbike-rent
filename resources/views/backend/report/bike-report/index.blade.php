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
    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Motor Rental Transaction Performance</h3>
                <form method="get" class="d-flex">
                    <select name="year" class="form-select me-2" onchange="this.form.submit()">
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <canvas id="motorRentalChart"></canvas>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tier</th>
                                    <th>Motor</th>
                                    <th>Transactions</th>
                                    <th>Total Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topMotors as $motor)
                                    @php
                                        $revenue = $motor->total_rental * 100000;
                                    @endphp
                                    @if ($revenue > 0)
                                        <tr class="tier-{{ $motor->tier }}">
                                            <td>{{ $motor->tier }}</td>
                                            <td>{{ $motor->name }}</td>
                                            <td>{{ $motor->total_rental }}</td>
                                            <td>Rp {{ number_format($revenue, 0, ',', '.') }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Add error handling
        document.addEventListener('DOMContentLoaded', function() {
            // Check if Chart is defined
            if (typeof Chart === 'undefined') {
                console.error('Chart.js not loaded');
                return;
            }

            const ctx = document.getElementById('motorRentalChart');

            if (!ctx) {
                console.error('Canvas element not found');
                return;
            }

            const chartData = {
                labels: @json($topMotors->pluck('name')),
                data: @json($topMotors->pluck('total_rental'))
            };

            console.log('Chart Data:', chartData);

            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Total Rental Transactions',
                        data: chartData.data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Rental Transactions'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
