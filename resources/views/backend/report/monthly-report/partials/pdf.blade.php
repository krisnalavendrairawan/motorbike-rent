<!DOCTYPE html>
<html>

<head>
    <title>Monthly Report - {{ $selectedMonth }} {{ $selectedYear }}</title>
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
        <h1>Monthly Report</h1>
        <h2>{{ $selectedMonth }} {{ $selectedYear }}</h2>
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
                <th>Date</th>
                <th>Motor</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->created_at->format('d M Y') }}</td>
                    <td>{{ $transaction->rental->motor->name ?? 'N/A' }}</td>
                    <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Detailed Expenses</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Motor</th>
                <th>Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($serviceExpenses as $service)
                <tr>
                    <td>{{ $service->service_date }}</td>
                    <td>{{ $service->motor->name ?? 'N/A' }}</td>
                    <td>Rp {{ number_format($service->cost, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
