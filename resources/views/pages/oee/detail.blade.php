@extends('components.elements.app')

@section('title', 'OEE - Overall Equipment Effectiveness')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>OEE (Overall Equipment Effectiveness)</h1>
            </div>

            @if (session('success') || session('error'))
                <div
                    class="alert {{ session('success') ? 'alert-success' : '' }} {{ session('error') ? 'alert-danger' : '' }} alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>x</span>
                        </button>
                        {{ session('success') }}
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" method="POST"
                            action="{{ route('oee.create', ['qid' => $data->id, 'pid' => $data->performance->id, 'aid' => $data->performance->availability->id]) }}">
                            @csrf
                            @method('POST')
                            <div class="form-group mb-2 row">
                                <h5 class="col-12 mb-6 text-center">Tanggal: {{ $data->updated_at }}</h5>
                                <h5 class="col-12 mb-3">Data OEE</h5>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="availability_ratio">Availability Ratio</label>
                                <input type="text" class="form-control col-3 mb-4"
                                    value="{{ $data->performance->availability->availability_ratio }}"
                                    name="availability_ratio" id="availability_ratio" disabled>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">(%)</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="performance_efficiency">Performance Efficiency</label>
                                <input type="text" class="form-control col-3 mb-4"
                                    value="{{ $data->performance->performance_efficiency }}" name="performance_efficiency"
                                    id="performance_efficiency" disabled>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">(%)</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="rate_of_quality_product">Rate of Quality Product</label>
                                <input type="text" class="form-control col-3 mb-4"
                                    value="{{ $data->rate_of_quality_product }}" name="rate_of_quality_product"
                                    id="rate_of_quality_product" disabled>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">(%)</p>

                                <h4 class="col-12 mb-3">Total</h4>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="availability_ratio">OEE</label>
                                <input type="text" class="form-control col-3 mb-4" name="oee" id="oee"
                                    disabled>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">%</p>

                                <h4 class="col-12 d-flex justify-content-start align-items-center mb-4 text-danger">
                                    * Target presentase overall equipment effectiveness = 85%
                                </h4>
                                <h3 class="col-12" id="oee-badge">
                                </h3>
                            </div>


                            <div class="mt-5 ">
                                <div>
                                    <a href="{{ route('index') }}" class="btn btn-success ml-2"
                                        id="button-lanjut">Lanjut</a>
                                    {{-- <button type="button" class="btn btn-primary ml-2" id="button-hitung">Hitung</button> --}}
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttonHitung = document.getElementById('button-hitung');
            const buttonReset = document.getElementById('button-reset');
            const buttonSimpan = document.getElementById('button-simpan');
            const buttonHapusSemua = document.getElementById('button-hapus-semua');
            const inputAvailabilityRatio = document.getElementById('availability_ratio');
            const inputPerformanceEfficiency = document.getElementById('performance_efficiency');
            const inputRateOfQualityProduct = document.getElementById('rate_of_quality_product');
            const inputOee = document.getElementById('oee');

            function hitung() {
                // Get the values
                const availabilityRatio = parseFloat(inputAvailabilityRatio.value) || 0;
                const performanceEfficiency = parseFloat(inputPerformanceEfficiency.value) || 0;
                const rateOfQualityProduct = parseFloat(inputRateOfQualityProduct.value) || 0;

                // Calculate OEE
                let oee = (availabilityRatio * performanceEfficiency * rateOfQualityProduct) / 10000;

                // Update the OEE input field
                oee = Math.min(100, Math.max(0, Math.round(oee)));

                inputOee.value = oee.toFixed(0);
                document.getElementById('button-simpan').removeAttribute('disabled');

                const badgeContainer = document.getElementById('oee-badge');

                // Clear previous badges
                badgeContainer.innerHTML = '';

                if (oee >= 85) {
                    const badgeAman = document.createElement('h3');
                    badgeAman.className = 'badge badge-success';
                    badgeAman.innerText =
                        'Kemampuan alat / mesin dalam menghasilkan produk sesuai standar sudah cukup baik (Tinggi)';

                    badgeContainer.appendChild(badgeAman);
                } else {
                    const badgeKurang = document.createElement('h3');
                    badgeKurang.className = 'badge badge-danger';
                    badgeKurang.innerText =
                        'Kemampuan alat / mesin dalam menghasilkan produk sesuai standar masih perlu diperbaiki (Rendah)';

                    badgeContainer.appendChild(badgeKurang);
                }
            };

            hitung();
        });
    </script>
@endsection

@push('scripts')
    <script>
        const buttonHitung = $('#button-hitung');
        const buttonReset = $('#button-reset');
        const buttonSimpan = $('#button-simpan');
        const buttonLanjut = $('#button-lanjut');
    </script>
@endpush
