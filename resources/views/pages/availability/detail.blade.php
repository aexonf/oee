@extends('components.elements.app')

@section('title', 'OE - Availability')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Availability</h1>
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
                            action="{{ route('availability.update', $availabilityData->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-2 mb-md-3 row">
                                <h5 class="col-12 mb-6 text-center">Tanggal: {{ $availabilityData->updated_at }}</h5>
                                <h5 class="col-12 mb-3">Total Working Time Machine</h5>

                                <label class="mb-3 col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="jam_kerja">Jam Kerja <span class="text-danger">*</span></label>
                                <input type="text" value="{{ $availabilityData->jam_kerja }}"
                                    class="mb-3 form-control col-3" name="jam_kerja" id="jam_kerja" required>
                                <p class="mb-3 col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="jam_total">Total</label>
                                <input type="text" class="form-control col-3" readonly name="jam_total" id="jam_total">
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="jam_lembur">Jam
                                    Lembur <span class="text-danger">*</span></label>
                                <input type="text" value="{{ $availabilityData->jam_lembur }}" class="form-control col-3"
                                    name="jam_lembur" id="jam_lembur" required>
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <h5 class="col-12 my-3">Loading Time</h5>

                                <label class="col-3 col-form-label d-flex justify-content-center align-items-center"
                                    for="total_machine_working_times">Total Working Time Machine<span
                                        class="text-danger">*</span></label>
                                <input type="text" value="{{ $availabilityData->total_machine_working_times }}"
                                    class="form-control col-2" id="total_machine_working_times"
                                    name="total_machine_working_times">
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="loading_time">Total</label>
                                <input type="text" class="form-control col-3" readonly name="loading_time"
                                    id="loading_time">
                                <p class="col-1 d-flex justify-content-center align-items-center"></p>

                                <label for="planned_downtime"
                                    class="col-3 col-form-label d-flex justify-content-center align-items-center mt-3">Planned
                                    Downtime <span class="text-danger">*</span></label>
                                <input value="{{ $availabilityData->planned_downtime }}" type="text"
                                    class="form-control col-2 mt-3" id="planned_downtime" name="planned_downtime" required>
                                <p class="col-1 d-flex justify-content-center align-items-center mt-3">menit</p>

                                <h5 class="col-12 my-3">Downtime</h5>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="breakdown"><b>Breakdown</b></label>
                                <input type="text" value="{{ $availabilityData->breakdown }}" class="form-control col-3"
                                    id="breakdown" name="breakdown">
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label class="mt-2 col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="total_downtime">
                                    Total
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control col-3 mt-3" id="total_downtime"
                                    name="total_downtime" readonly>
                                <p class="col-1 d-flex justify-content-center align-items-end">menit</p>

                                <label class="mt-2 col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="setup_adjustment"><b>
                                        Setup and Adjustment
                                    </b></label>
                                <input type="text" value="{{ $availabilityData->setup_adjustment }}"
                                    class="form-control col-3 mt-3" id="setup_adjustment" name="setup_adjustment">
                                <p class="col-1 d-flex justify-content-center align-items-end">menit</p>

                                <h4 class="col-12 my-4">Total</h4>

                                <label class="mt-2 col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="operation_time">
                                    Operation Time
                                    <span class="text-danger">*</span>
                                </label>
                                <input value="{{ $availabilityData->operation_time }}" type="text"
                                    class="form-control col-3 mt-3" id="operation_time" name="operation_time" readonly>
                                <p class="col-1 d-flex justify-content-center align-items-end">menit</p>


                                <label class="mt-2 col-2 col-form-label d-flex justify-content-center align-items-center">
                                    Availability
                                    Ratio
                                </label>
                                <input value="{{ $availabilityData->availability_ratio }}" type="text"
                                    class="form-control col-3 mt-3" id="availability_ratio" name="availability_ratio"
                                    readonly>
                                <p class="col-1 d-flex justify-content-center align-items-end">%</p>
                                <div class="col-6"></div>
                                <div class="col-6 mt-4">
                                    <h5 class="text-danger">
                                        * Target presentase availability ratio = <span class="text-black">85%</span>
                                    </h5>
                                </div>
                                <div class="col-12" id="availiability_ratio_value">
                                </div>

                            </div>
                            <div class="mt-5 d-flex justify-content-between">
                                <div>
                                    {{-- <button type="button" class="btn btn-primary ml-2" id="button-hitung"
                                        onclick="hitung()">Hitung</button> --}}
                                    {{-- <a href="{{ route('availability') }}" class="btn btn-danger ml-2">Reset</a> --}}
                                </div>
                                <div>
                                    <form action="{{ route('availability.update', $availabilityData->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        {{-- <button type="submit" class="btn btn-primary ml-2" id="button-simpan"
                                        >Update</button> --}}
                                    </form>
                                    <a href="{{ route('performance.detail', $availabilityData->id) }}"
                                        class="btn btn-success ml-2" id="button-lanjut">Lanjut</a>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
    </div>
    </section>
    </div>

    <script>
        function hitung() {

            const jamKerja = parseInt(document.getElementById('jam_kerja').value) || 0;
            const jamLembur = parseInt(document.getElementById('jam_lembur').value) || 0;
            const plannedDowntime = parseInt(document.getElementById('planned_downtime').value) || 0;
            const breakdown = parseInt(document.getElementById('breakdown').value) || 0;
            const setupAdjustment = parseInt(document.getElementById('setup_adjustment').value) || 0;

            const machineWorkingTimes = jamKerja + jamLembur;
            const loadingTime = machineWorkingTimes - plannedDowntime;
            const downtime = breakdown + setupAdjustment;
            const operationTime = (loadingTime - downtime);
            let availabilityRatio = operationTime / loadingTime * 100;

            document.getElementById('total_machine_working_times').value = machineWorkingTimes;
            document.getElementById('loading_time').value = loadingTime;
            document.getElementById('operation_time').value = operationTime;

            availabilityRatio = Math.min(100, Math.max(0, Math.round(availabilityRatio)));
            document.getElementById('availability_ratio').value = availabilityRatio.toFixed(0);
            document.getElementById('jam_total').value = machineWorkingTimes;
            document.getElementById('total_downtime').value = downtime;

            const badgeContainer = document.getElementById('availiability_ratio_value');

            // Clear previous badges
            badgeContainer.innerHTML = '';

            if (availabilityRatio >= 85) {
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

            document.getElementById('button-simpan').removeAttribute('disabled');
        }

        hitung()
    </script>
@endsection
