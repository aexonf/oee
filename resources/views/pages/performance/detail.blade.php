@extends('components.elements.app')

@section('title', 'OEE - Performance Efficiency')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Performance Efficiency</h1>
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
                        <form class="needs-validation" method="POST" action="{{ route('performance.update', $id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-2 row">
                                <h5 class="col-12 mb-6 text-center">Tanggal: {{ $data->updated_at }}</h5>
                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="jumlah_produksi">Jumlah Produksi <span class="text-danger">*</span></label>
                                <input value="{{ $data->jumlah_produksi }}" type="text" class="form-control col-3 mb-4"
                                    name="jumlah_produksi" id="jumlah_produksi">
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">unit</p>

                                <h5 class="col-12 mb-3">Cycle Time</h5>
                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="loading_time">Loading Time <span class="text-danger">*</span></label>
                                <input type="text" readonly value="{{ $avaibility->loading_time }}"
                                    class="form-control col-3 mb-4" name="loading_time" id="loading_time">
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">menit / unit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="cycle_time_total">Total</label>
                                <input type="text" class="form-control col-3" readonly name="cycle_time_total"
                                    id="cycle_time_total">
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="processed_amount">Processed Amount <span class="text-danger">*</span></label>
                                <input type="text" value="{{ $data->processed_amount }}" class="form-control col-3 mb-4"
                                    name="processed_amount" id="processed_amount">
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">unit</p>

                                <h5 class="col-12 mb-3">Ideal Cycle Time</h5>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="cycle_time">Cycle time <span class="text-danger">*</span></label>
                                <input type="text" value="{{ $data->cycle_time }}" class="form-control col-3 mb-4 "
                                    name="cycle_time" id="cycle_time">
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">menit / unit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="total_ideal_cycle_time">Total <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3 mb-4 " name="total_ideal_cycle_time"
                                    id="total_ideal_cycle_time" readonly>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="jam_kerja">Jam Kerja <span class="text-danger">*</span></label>
                                <input value="{{ $avaibility->jam_kerja }}" readonly type="text"
                                    class="form-control col-3 mb-4 " name="jam_kerja" id="jam_kerja">
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">menit</p>

                                <div class="col-6"></div>
                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="operation_time">Operation Time</label>
                                <input type="text" class="form-control col-3 mb-4 " name="operation_time"
                                    value="{{ $avaibility->operation_time }}" id="operation_time" readonly>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">menit</p>

                                <h5 class="col-12 mb-3">Total</h5>
                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="performance_efficiency">Performance Efficiency</label>
                                <input type="text" value="{{ $data->performance_efficiency }}"
                                    class="form-control col-3 mb-4 " name="performance_efficiency"
                                    id="performance_efficiency" readonly>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">%</p>
                                <h3 class="col-12 d-flex justify-content-start align-items-center mb-4 text-danger">
                                    * Target presentase performance ratio = 85%
                                </h3>
                                <h3 class="col-12" id="performance_efficiency_val">
                                </h3>

                            </div>
                            <div class="mt-5 d-flex justify-content-between">
                                <div class="d-flex justify-content-end">
                                    {{-- <button type="button" class="btn btn-primary ml-2" id="button-hitung"
                                        onclick="hitung()">Hitung</button>
                                    <a href="{{ route('performance', $id) }}" class="btn btn-danger ml-2"
                                        id="button-reset">Reset</a> --}}
                                </div>
                                <div class="d-flex justify-content-end">
                                    <form action="{{ route('performance.update', $data->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        {{-- <button type="submit" class="btn btn-primary ml-2"
                                            id="button-simpan">Update</button> --}}
                                    </form>
                                    <a href='{{ route('quality.detail', $data->id) }}' class="btn btn-primary ml-2"
                                        id="button-simpan">Lanjut</a>
                                    <a href='{{ route('availability.detail', $data->id) }}' class="btn btn-primary ml-2"
                                        id="button-simpan">Kembali</a>
                                </div>
                        </form>
                    </div>
                </div>

            </div>
    </div>
    </section>
    </div>

    <script>
        // Check if idealCycleTime is zero
        // if (idealCycleTime === 0) {
        //     // Handle the case where idealCycleTime is zero (for example, set targetProduksi to a default value)
        //     document.getElementById('processed_amount').value = 0;
        //     document.getElementById('actual_cycle_time').value = 0;
        //     document.getElementById('performance_efficiency').value = 0;

        //     // Display an error message or handle it as needed
        //     console.error("Error: idealCycleTime should not be zero.");
        //     return;
        // }

        // // Calculate target produksi
        // const targetProduksi = operationTime / idealCycleTime;

        // // Handle the case where targetProduksi is Infinity
        // if (!isFinite(targetProduksi)) {
        //     // Set targetProduksi to a default value or display an error message
        //     document.getElementById('processed_amount').value = 0;
        //     document.getElementById('actual_cycle_time').value = 0;
        //     document.getElementById('performance_efficiency').value = 0;

        //     // Display an error message or handle it as needed
        //     console.error("Error: Target Produksi is Infinity.");
        //     return;
        // }

        // document.getElementById('processed_amount').value = targetProduksi;


        function hitung() {

            /*
            1. total cycle time = loading time / processed amount
            2. total ideal cycle time = cycle time * jam kerja
            3. performance = jumlah produksi - ideal cycle time / operation time * 100%
            */

            // Get input values
            const loadingTime = parseFloat(document.getElementById('loading_time').value) || 0;
            const processedAmount = parseFloat(document.getElementById('processed_amount').value) || 0;
            const jumlahProduksi = parseInt(document.getElementById('jumlah_produksi').value) || 0;
            const operationTime = parseFloat(document.getElementById('operation_time').value) || 0;
            const cycleTime = parseFloat(document.getElementById('cycle_time').value) || 0;
            const jamKerja = parseFloat(document.getElementById('jam_kerja').value) || 0;


            const cycleTimeTotal = loadingTime / processedAmount;
            document.getElementById('cycle_time_total').value = cycleTimeTotal;

            const idealCycleTimeTotal = cycleTime * jamKerja;
            document.getElementById('total_ideal_cycle_time').value = idealCycleTimeTotal;

            // Calculate performance efficiency
            let performanceEfficiency = (jumlahProduksi - idealCycleTimeTotal) / operationTime / 10;
            performanceEfficiency = Math.min(100, Math.max(0, Math.round(performanceEfficiency)));
            console.log(performanceEfficiency)

            document.getElementById('performance_efficiency').value = performanceEfficiency.toFixed(0);

            const badgeContainer = document.getElementById('performance_efficiency_val');

            // Clear previous badges
            badgeContainer.innerHTML = '';

            if (performanceEfficiency >= 85) {
                const badgeAman = document.createElement('h3');
                badgeAman.className = 'badge badge-success';
                badgeAman.innerText =
                    'Pengguna waktu yang tersedia untuk kegiatan operasi mesin alat sudah mencukupi (Tinggi)';

                badgeContainer.appendChild(badgeAman);
            } else {
                const badgeKurang = document.createElement('h3');
                badgeKurang.className = 'badge badge-danger';
                badgeKurang.innerText =
                    'Pengguna waktu yang tersedia untuk kegiatan operasi mesin alat belum mencukupi (Kurang)';

                badgeContainer.appendChild(badgeKurang);
            }
            // Enable the buttons
            document.getElementById('button-simpan').removeAttribute('disabled');
        }

        hitung()
    </script>

@endsection
