<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Performance</th>
            <th>Quality</th>
            <th>Availability</th>
            <th>Total</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($data as $value)
            <tr>
                <td>{{ $value->created_at }}</td>
                <td>{{ $value->availability->availability_ratio }}</td>
                <td>{{ $value->performance->performance_efficiency }}</td>
                <td>{{ $value->quality->rate_of_quality_product }}</td>
                <td>{{ floor(($value->availability->availability_ratio * $value->performance->performance_efficiency * $value->quality->rate_of_quality_product) / 10000) }}


            </tr>
        @endforeach
    </tbody>
</table>
