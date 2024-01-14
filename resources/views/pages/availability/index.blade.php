@extends('components.elements.app')

@section('title', 'OEE - Availability Ratio')

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
                    <div class="card-header">
                        <h4>Total</h4>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" method="POST" action="{{ route('availability.create') }}">
                            @csrf
                            @method('POST')
                            <div class="form-group mb-2 mb-md-3 row">
                                <h5 class="col-12 mb-3">Machine Working Times</h5>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="jam_kerja">Jam Kerja <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3" name="jam_kerja" id="jam_kerja" required>
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center">Jam
                                    Lembur <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3" name="jam_lembur" id="jam_lembur" required>
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <h5 class="col-12 my-3">Loading Time</h5>

                                <label class="col-3 col-form-label d-flex justify-content-center align-items-center"
                                    for="machine_working_times">Machine Working Machine <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control col-2" id="machine_working_times"
                                    name="machine_working_times" readonly>
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center">Planned
                                    Downtime <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3" id="planned_downtime"
                                    name="planned_downtime" required>
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <h5 class="col-12 my-3">Operation Time</h5>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="loading_time"><b>Loading Time</b></label>
                                <input type="text" class="form-control col-3" id="loading_time" name="loading_time"
                                    readonly>
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="failure_repair">Failure and Repair <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3" id="failure_repair" name="failure_repair"
                                    required>
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label
                                    class="mt-2 col-3 col-form-label d-flex justify-content-start align-items-center">Setup
                                    and Adjustment <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-2 mt-3" id="setup_adjustment"
                                    name="setup_adjustment" required>
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label
                                    class="mt-2 col-2 col-form-label d-flex justify-content-center align-items-center"><b>
                                        Operation
                                        Time
                                    </b></label>
                                <input type="text" class="form-control col-3 mt-3" id="operation_time"
                                    name="operation_time" readonly>
                                <p class="col-1 d-flex justify-content-center align-items-end">menit</p>

                                <label
                                    class="mt-2 col-2 col-form-label d-flex justify-content-center align-items-center text-decoration-underline"><u>
                                        Availability
                                        Ratio
                                    </u></label>
                                <input type="text" class="form-control col-3 mt-3" id="availability_ratio"
                                    name="availability_ratio" readonly>
                                <p class="col-1 d-flex justify-content-center align-items-end">%</p>
                                <div class="col-6"></div>
                                <div class="col-6 mt-4">
                                    <h5 class="text-danger">
                                        * Target presentase availability ratio = <span class="text-black">90%</span>
                                    </h5>
                                </div>
                                <h3 class="col-12" id="availiability_ratio">
                                </h3>

                            </div>
                            <div class="mt-5 d-flex justify-content-between">
                                <div>
                                    <button type="button" class="btn btn-primary ml-2" id="button-hitung"
                                        onclick="hitung()">Hitung</button>
                                    <a href="{{ route('availability') }}" class="btn btn-danger ml-2">Reset</a>
                                </div>
                                <div>
                                    <form action="{{ route('availability.create') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-primary ml-2" id="button-simpan"
                                            disabled>Simpan</button>
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
                                                    <th>Jam Kerja</th>
                                                    <th>Jam Lembur</th>
                                                    <th>Planned Downtime</th>
                                                    <th>Loading Time</th>
                                                    <th>Failure & Repair</th>
                                                    <th>Setup & Adjustment</th>
                                                    <th>Operation Time</th>
                                                    <th>Availality Ratio</th>
                                                    <th>Action</th>
                                                </tr>

                                                @if (session('success') && session('data'))
                                                    <?php $availabilityData = json_decode(session('data')); ?>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>{{ $availabilityData->jam_kerja }}</td>
                                                        <td>{{ $availabilityData->jam_lembur }}</td>
                                                        <td>{{ $availabilityData->planned_downtime }}</td>
                                                        <td>{{ $availabilityData->loading_time }}</td>
                                                        <td>{{ $availabilityData->failure_repair }}</td>
                                                        <td>{{ $availabilityData->setup_adjustment }}</td>
                                                        <td>{{ $availabilityData->operation_time }}</td>
                                                        <td>{{ $availabilityData->availability_ratio }}</td>
                                                        <td>
                                                            <a href="{{ route('performance', $availabilityData->id) }}"
                                                                class="btn btn-success ml-2" id="button-lanjut">Lanjut</a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{-- <div class="d-flex justify-content-end my-5">
                            <a href="{{ route('performance', ['id' => 1]) }}" class="btn btn-success ml-2"
                                id="button-lanjut">Lanjut</a>
                        </div> --}}
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
            const failureRepair = parseInt(document.getElementById('failure_repair').value) || 0;
            const setupAdjustment = parseInt(document.getElementById('setup_adjustment').value) || 0;

            const machineWorkingTimes = jamKerja + jamLembur;
            const loadingTime = machineWorkingTimes - plannedDowntime;
            const operationTime = (loadingTime - failureRepair) - setupAdjustment;
            const availabilityRatio = operationTime / loadingTime * 100;

            document.getElementById('machine_working_times').value = machineWorkingTimes;
            document.getElementById('loading_time').value = loadingTime;
            document.getElementById('operation_time').value = operationTime;
            document.getElementById('availability_ratio').value = availabilityRatio;

            const badgeContainer = document.getElementById('availiability_ratio');

            // Clear previous badges
            badgeContainer.innerHTML = '';

            if (availabilityRatio >= 90) {
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
