<!DOCTYPE html>
<html>

<head>
    <title>Yearly Report {{ $selectedYear }}</title>
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
    <h1>Yearly Report {{ $selectedYear }}</h1>

    <div class="summary">
        <h2>Financial Summary</h2>
        <p>Total Income: Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        <p>Total Expenses: Rp {{ number_format($totalExpenses, 0, ',', '.') }}</p>
    </div>

    <h2>Transaction Details</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Motor</th>
                <th>Amount</th>
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

    <h2>Service Expenses</h2>
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
                    <td>{{ \Carbon\Carbon::parse($service->service_date)->format('d M Y') }}</td>
                    <td>{{ $service->motor->name ?? 'N/A' }}</td>
                    <td>Rp {{ number_format($service->cost, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
