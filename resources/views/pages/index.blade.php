@extends('components.elements.app')

@section('title', 'Admin - Dashboard')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content mx-auto">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-primary">
                            Statistics
                        </h1>
                    </div>
                    <div class="card-body">
                        <canvas id="cart-data" style="height: 320px; width: 100%;"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>OEE (Overall Equipment Effectiveness)</h3>
                        <a href="{{ route('availability') }}" class="btn btn-primary btn-lg">
                            Buat
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Availability Ratio</th>
                                    <th scope="col">Performance Efficiency</th>
                                    <th scope="col">Rate Of Quality Product</th>
                                    <th scope="col">Overall Equipment Effectiveness</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $item->availability->availability_ratio }}</td>
                                        <td>{{ $item->performance->performance_efficiency }}</td>
                                        <td>{{ $item->quality->rate_of_quality_product }}</td>
                                        <td>{{ ($item->availability->availability_ratio * $item->performance->performance_efficiency * $item->quality->rate_of_quality_product) / 10000 }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </section>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
<script>
    const dataArray = {!! $dataOee !!};
    const data = dataArray.map(item => item);

    const ctxData = document.getElementById('cart-data');

    new Chart(ctxData, {
        type: 'bar',
        data: {
            labels: data.map(item => new Date(item.date).toLocaleDateString()),
            datasets: [{
                label: 'OEE',
                data: data.map(item => {
                    let value = item.averageOee;

                    if (value < 0) {
                        value = 0;
                    }

                    value = Math.min(value, 100);

                    return value;
                }),
                backgroundColor: '#6777ef'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                }
            }
        }
    });
</script>

    @if (session('success'))
        <script>
            document.getElementById('route-admin').click();
        </script>
    @endif
@endpush
