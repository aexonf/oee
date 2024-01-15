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
                        <form class="needs-validation" method="POST" action="{{ route('performance.create', $id) }}">
                            @csrf
                            @method('POST')
                            <div class="form-group mb-2 row">

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="cycle_time">Ideal Cycle Time <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3 mb-4" name="cycle_time" id="cycle_time">
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">menit / unit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="jumlah_produksi">Jumlah Produksi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3 mb-4" name="jumlah_produksi"
                                    id="jumlah_produksi">
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">unit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="target_produksi">Jumlah Target Produksi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3 mb-4" readonly name="target_produksi"
                                    id="target_produksi">
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">unit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="actual_cycle_time">Actual Cycle time <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3 mb-4 " readonly name="actual_cycle_time"
                                    id="actual_cycle_time">
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">menit / unit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="operation_time">Operation Time <span class="text-danger">*</span></label>
                                <input value="{{ $data->operation_time }}" type="text" class="form-control col-3 mb-4 "
                                    name="operation_time" id="operation_time" readonly>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">menit</p>

                                <h5 class="col-12 mb-3">Total</h5>
                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="performance_efficiency">Performance Efficiency</label>
                                <input type="text" class="form-control col-3 mb-4 " name="performance_efficiency"
                                    id="performance_efficiency" readonly>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">%</p>
                                <h3 class="col-12 d-flex justify-content-start align-items-center mb-4 text-danger">
                                    * Target presentase availability ratio = 95%
                                </h3>
                                <h3 class="col-12" id="performance_efficiency_val">
                                </h3>


                            </div>
                            <div class="mt-5 d-flex justify-content-between">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary ml-2" id="button-hitung"
                                        onclick="hitung()">Hitung</button>
                                    <a href="{{ route('performance', $id) }}" class="btn btn-danger ml-2"
                                        id="button-reset">Reset</a>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary ml-2" id="button-simpan"
                                        disabled>Simpan</button>
                                </div>
                        </form>
                    </div>
                </div>
                {{-- card --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Table</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive overflow-x-auto">
                            <table class="table table-striped table-md">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Operation Time</th>
                                        <th>Jumlah Produksi</th>
                                        <th>Target Produksi</th>
                                        <th>Actual Cycle Time</th>
                                        <th>Ideal Cycle Time</th>
                                        <th>Performance Efficiency</th>
                                        <th>Action</th>
                                    </tr>

                                    <tr>
                                        @if (session('success') && session('performance'))
                                        <?php $count = 1;  ?>
                                        <?php $availabilityData = json_decode(session('performance')); ?>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $data->operation_time }}</td>
                                            <td>{{ $availabilityData->jumlah_produksi }}</td>
                                            <td>{{ $availabilityData->target_produksi }}</td>
                                            <td>{{ $availabilityData->actual_cycle_time }}</td>
                                            <td>{{ $availabilityData->cycle_time }}</td>
                                            <td>{{ $availabilityData->performance_efficiency }}</td>
                                            <td class="d-flex">
                                                <a href="{{ route('quality', $availabilityData->id) }}"
                                                    class="btn btn-success ml-2" id="button-lanjut">Lanjut</a>
                                                <form action="{{ route('performance.delete', $availabilityData->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger ml-2"
                                                        id="button-hapus-semua">Hapus</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end my-5 p-5">
                    {{-- dapetin id nya --}}
                    <a href='{{ route('availability') }}' class="btn btn-primary ml-2" id="button-simpan">Kembali</a>
                </div>
            </div>
    </div>
    </div>
    </section>
    </div>

    <script>
        function hitung() {
            // Get input values
            const idealCycleTime = parseFloat(document.getElementById('cycle_time').value) || 0;
            const jumlahProduksi = parseInt(document.getElementById('jumlah_produksi').value) || 0;

            // Calculate actual cycle time
            const operationTime = parseFloat(document.getElementById('operation_time').value) || 0;

            // Check if idealCycleTime is zero
            if (idealCycleTime === 0) {
                // Handle the case where idealCycleTime is zero (for example, set targetProduksi to a default value)
                document.getElementById('target_produksi').value = 0;
                document.getElementById('actual_cycle_time').value = 0;
                document.getElementById('performance_efficiency').value = 0;

                // Display an error message or handle it as needed
                console.error("Error: idealCycleTime should not be zero.");
                return;
            }

            // Calculate target produksi
            const targetProduksi = operationTime / idealCycleTime;

            // Handle the case where targetProduksi is Infinity
            if (!isFinite(targetProduksi)) {
                // Set targetProduksi to a default value or display an error message
                document.getElementById('target_produksi').value = 0;
                document.getElementById('actual_cycle_time').value = 0;
                document.getElementById('performance_efficiency').value = 0;

                // Display an error message or handle it as needed
                console.error("Error: Target Produksi is Infinity.");
                return;
            }

            document.getElementById('target_produksi').value = targetProduksi;

            const actualCycleTime = operationTime / jumlahProduksi;
            document.getElementById('actual_cycle_time').value = actualCycleTime;

            // Calculate performance efficiency
            const performanceEfficiency = (jumlahProduksi * idealCycleTime) / operationTime * 100;
            document.getElementById('performance_efficiency').value = performanceEfficiency;

            const badgeContainer = document.getElementById('performance_efficiency_val');

            // Clear previous badges
            badgeContainer.innerHTML = '';

            if (performanceEfficiency >= 95) {
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
