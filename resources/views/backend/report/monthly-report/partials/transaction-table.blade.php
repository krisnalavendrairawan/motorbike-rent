<table class="table table-striped table-hover">
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
