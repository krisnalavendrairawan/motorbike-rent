<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }} Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 18px;
        }

        .date {
            text-align: right;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .finished {
            color: #198754;
            font-weight: bold;
        }

        .rented {
            color: #ffc107;
            font-weight: bold;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #dc3545;
            font-size: 14px;
            font-weight: bold;
            border: 2px dashed #dc3545;
            margin: 20px 0;
            background-color: #fff5f5;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $title }} Report</h1>
    </div>

    <div class="date">
        <div>Generated on: {{ $date }}</div>
        <div>{{ $filter_info }}</div>
    </div>

    @if ($has_data)
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Customer</th>
                    <th>Bike</th>
                    <th>Return Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($returns as $index => $return)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $return['customer_name'] }}</td>
                        <td>{{ $return['motor_name'] }}</td>
                        <td>{{ $return['return_date'] }}</td>
                        <td>{{ $return['total_price'] }}</td>
                        <td class="{{ $return['status'] === 'Selesai' ? 'finished' : 'rented' }}">
                            {{ $return['status'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            Tidak ada data {{ __('label.return') }} yang tersedia untuk periode {{ $filter_info }}
        </div>
    @endif
</body>

</html>
