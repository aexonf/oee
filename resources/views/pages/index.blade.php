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
                                    <th scope="row">{{$index + 1}}</th>
                                    <td>{{$item->availability->availability_ratio}}</td>
                                    <td>{{$item->performance->performance_efficiency}}</td>
                                    <td>{{$item->quality->rate_of_quality_product}}</td>
                                    <td>{{ $item->availability->availability_ratio * $item->performance->performance_efficiency * $item->quality->rate_of_quality_product / 10000 }}</td>
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
    @if (session('success'))
        <script>
            document.getElementById('route-admin').click();
        </script>
    @endif
@endpush
