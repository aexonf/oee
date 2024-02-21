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
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>{{ $item->availability->availability_ratio }}</td>
                                        <td>{{ $item->performance->performance_efficiency }}</td>
                                        <td>{{ $item->quality->rate_of_quality_product }}</td>
                                        <td>{{ round(($item->availability->availability_ratio * $item->performance->performance_efficiency * $item->quality->rate_of_quality_product) / 10000, 0) }}
                                        </td>
                                        <td><a href="{{route('availability.detail', $item->availability->id)}}"><i class="bi bi-eye-fill"></i></a></td>
                                    </tr>
                                @endforeach
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
        document.addEventListener('DOMContentLoaded', function() {
            const dataArray = {!! $dataOee !!};
            const data = dataArray.map(item => item);

            const ctxData = document.getElementById('cart-data');

            let arrays = [];

            if (ctxData) {
                new Chart(ctxData, {
                    type: 'bar',
                    data: {
                        labels: data.map(item => new Date(item.date).toLocaleDateString()),
                        datasets: [{
                            label: 'OEE',
                            data: data.map(item => {
                                const availabilityRatio = item.data.map(innerItem =>
                                    innerItem.availability.availability_ratio);
                                const performanceEfficiency = item.data.map(innerItem =>
                                    innerItem.performance.performance_efficiency);
                                const rateOfQualityProduct = item.data.map(innerItem =>
                                    innerItem.quality.rate_of_quality_product);

                        const oeeValues = availabilityRatio.map((ratio, index) => {
                            let oee = Math.abs((ratio * performanceEfficiency[index] *
                                rateOfQualityProduct[index]) / 10000);
                            oee = Math.max(0, Math.min(100, oee));
                            return oee;
                        });


                                const averageOEE = oeeValues.reduce((acc, value) => acc +
                                    value, 0) / oeeValues.length;

                                arrays.push(averageOEE);

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
            }

            // Menghitung total oee nya
            /*
            1. di js nya di bagian result data nya di push buat var baru
            2. hitung
            */
            const nonNaNData = arrays.filter(value => !isNaN(value));
            const numberOfNonNaN = nonNaNData.length;
            let totalOee = 0;
            arrays.forEach(item => {
                if (!isNaN(item)) {
                    totalOee += item / numberOfNonNaN;
                }
            });

            console.log("Total OEE:", totalOee);
            document.getElementById("totalOee").value = totalOee;

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
