<!DOCTYPE html>
<html>

<head>
    <title>Weekly Report - {{ $selectedMonth }} {{ $selectedYear }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Weekly Report</h1>
        <h2>Period: {{ $startDate }} - {{ $endDate }}</h2>
    </div>

    <div class="summary">
        <div class="summary-card">
            <h3>Income Summary</h3>
            <p>Total Transactions: {{ $transactions->count() }}</p>
            <p>Total Income: Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
        <div class="summary-card">
            <h3>Expense Summary</h3>
            <p>Total Services: {{ $serviceExpenses->count() }}</p>
            <p>Total Expenses: Rp {{ number_format($totalExpenses, 0, ',', '.') }}</p>
        </div>
    </div>

    <h3>Detailed Income</h3>
    <table>
        <thead>
            <tr>
                <th class="date">Date</th>
                <th>Motor</th>
                <th>Customer</th>
                <th class="amount">Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->created_at->format('d M Y') }}</td>
                    <td>{{ $transaction->rental->motor->name ?? 'N/A' }}</td>
                    <td>{{ $transaction->rental->customer->name ?? 'N/A' }}</td>
                    <td class="amount">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">Total Income</td>
                <td class="amount">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h3>Detailed Expenses</h3>
    <table>
        <thead>
            <tr>
                <th class="date">Date</th>
                <th>Motor</th>
                <th>Description</th>
                <th class="amount">Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($serviceExpenses as $service)
                <tr>
                    <td>{{ Carbon\Carbon::parse($service->service_date)->format('d M Y') }}</td>
                    <td>{{ $service->motor->name ?? 'N/A' }}</td>
                    <td>{{ $service->description ?? '-' }}</td>
                    <td class="amount">Rp {{ number_format($service->cost, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">Total Expenses</td>
                <td class="amount">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
