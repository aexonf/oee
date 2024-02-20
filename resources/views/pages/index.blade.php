@extends('components.elements.app')

@section('title', 'Admin - Dashboard')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>OEE (Overall Equipment Effectiveness)</h3>
                        <div class="d-flex align-items-center">
                            <div class="form-group mr-3 mb-0">
                                <input type="date" class="form-control" id="start_date" name="from">
                            </div>
                            <div class="form-group mr-3 mb-0">
                                <input type="date" class="form-control" id="end_date" name="to">
                            </div>
                            <button type="button" class="btn btn-icon icon-left btn-info mr-2" data-toggle="collapse"
                                data-target="#section-filter"><i class="fas fa-filter"></i>
                                Filter</button>
                            <form action="{{ route('index.export') }}" method="get">
                                @csrf
                                @method('GET')
                                <button type="submit" class="btn btn-icon icon-left btn-primary mr-2 mt-3"><i
                                        class="fas fa-download"></i>
                                    Export</button>
                            </form>
                            <a href="{{ route('availability') }}" class="btn btn-primary btn-lg ml-3">Buat</a>
                        </div>
                    </div>


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
                                <th scope="col">Action</th>
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
                                    <td><a href="{{ route('availability.detail', $item->availability->id) }}"><i
                                                class="bi bi-eye-fill"></i></a></td>
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
                        const availabilityRatio = item.data.map(innerItem => innerItem.availability
                            .availability_ratio);
                        const performanceEfficiency = item.data.map(innerItem => innerItem
                            .performance.performance_efficiency);
                        const rateOfQualityProduct = item.data.map(innerItem => innerItem.quality
                            .rate_of_quality_product);

                        const oeeValues = availabilityRatio.map((ratio, index) => {
                            let oee = Math.abs((ratio * performanceEfficiency[index] *
                                rateOfQualityProduct[index]) / 10000);
                            oee = Math.max(0, Math.min(100, oee));
                            return oee;
                        });

                        const averageOEE = oeeValues.reduce((acc, value) => acc + value, 0) /
                            oeeValues.length;

                        return averageOEE;
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

    @push('scripts')
        <!-- JS Libraries -->
        <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('library/datatables/media/js/dataTables.min.js') }}"></script>
        <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
        <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });

            const handleChangeFilter = (e) => {
                const currentURL = new URL(window.location.href);
                currentURL.searchParams.set(e.name, e.value);
                window.history.pushState({}, '', currentURL);
                location.reload();
            }
        </script>
    @endpush
