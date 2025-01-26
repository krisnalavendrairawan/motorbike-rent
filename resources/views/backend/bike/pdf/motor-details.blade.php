<!DOCTYPE html>
<html>
<head>
    <title>Motor Details - {{ $motor->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 15px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Motor Details: {{ $motor->name }}</h1>
    </div>

    <div class="section">
        <h2>Motor Information</h2>
        <table class="table">
            <tr>
                <th>Plat Nomor</th>
                <td>{{ $motor->plate }}</td>
            </tr>
            <tr>
                <th>Brand</th>
                <td>{{ $motor->brand->name }}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{{ $motor->type }}</td>
            </tr>
            <tr>
                <th>Color</th>
                <td>{{ $motor->color }}</td>
            </tr>
            <tr>
                <th>Daily Rental Price</th>
                <td>Rp {{ number_format($motor->price, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Financial Summary</h2>
        <table class="table">
            <tr>
                <th>Total Service Costs</th>
                <td>Rp {{ number_format($totalServiceCost, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Rental Income</th>
                <td>Rp {{ number_format($totalRentalIncome, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Net Income</th>
                <td>Rp {{ number_format($totalRentalIncome - $totalServiceCost, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>