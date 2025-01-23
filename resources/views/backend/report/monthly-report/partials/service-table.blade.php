<table class="table table-striped table-hover">
    <tbody id="service-table-body">
        @foreach ($serviceExpenses as $service)
            <tr>
                <td>{{ Carbon\Carbon::parse($service->service_date)->format('d M Y') }}</td>
                <td>{{ $service->motor->name ?? 'N/A' }}</td>
                <td>Rp {{ number_format($service->cost, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
