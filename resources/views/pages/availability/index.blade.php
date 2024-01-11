@extends('components.elements.app')

@section('title', 'Simaku Admin - Setting')

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
                        <form class="needs-validation" method="get" action="#">
                            @csrf
                            <div class="form-group mb-2 mb-md-3 row">
                                <h5 class="col-12 mb-3">Machine Working Times</h5>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="jam_kerja">Jam Kerja <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3" name="jam_kerja" id="jam_kerja">
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center">Jam
                                    Lembur <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3" name="jam_lembur" id="jam_lembur">
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <h5 class="col-12 my-3">Loading Time</h5>

                                <label class="col-3 col-form-label d-flex justify-content-center align-items-center"
                                    for="machine_working_times">Machine Working Machine <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control col-2" name="machine_working_times" disabled>
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center">Planned
                                    Downtime <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3" name="planned_downtime">
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <h5 class="col-12 my-3">Operation Time</h5>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="loading_time"><b>Loading Time</b></label>
                                <input type="text" class="form-control col-3" name="loading_time" disabled>
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center"
                                    for="failure_repair">Failure and Repair <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3" name="failure_repair">
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label
                                    class="mt-2 col-3 col-form-label d-flex justify-content-start align-items-center">Setup
                                    and Adjustment <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-2 mt-3" name="setup_adjustment">
                                <p class="col-1 d-flex justify-content-center align-items-center">menit</p>

                                <label
                                    class="mt-2 col-2 col-form-label d-flex justify-content-center align-items-center"><b>
                                        Operation
                                        Time
                                    </b></label>
                                <input type="text" class="form-control col-3 mt-3" name="operation_time" disabled>
                                <p class="col-1 d-flex justify-content-center align-items-end">menit</p>

                                <label
                                    class="mt-2 col-2 col-form-label d-flex justify-content-center align-items-center text-decoration-underline"><u>
                                        Availability
                                        Ratio
                                    </u></label>
                                <input type="text" class="form-control col-3 mt-3" name="availability_ratio" disabled>
                                <p class="col-1 d-flex justify-content-center align-items-end">%</p>
                                <div class="col-6"></div>
                                <div class="col-6 mt-4">
                                    <h5 class="text-danger">
                                        * Target presentase availability ratio = <span class="text-black">90%</span>
                                    </h5>
                                </div>

                            </div>
                            <div class="mt-5 d-flex justify-content-between">
                                <div>
                                    <button type="submit" class="btn btn-primary ml-2" id="button-hitung">Hitung</button>
                                    <button type="submit" class="btn btn-danger ml-2 disabled" id="button-reset"
                                        disabled>Reset</button>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary ml-2 disabled" id="button-simpan"
                                        disabled>Simpan</button>
                                    <button type="submit" class="btn btn-danger ml-2 disabled" id="button-lanjut"
                                        disabled>Lanjut</button>
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
                                                    <th>Jam Kerja</th>
                                                    <th>Jam Lembur</th>
                                                    <th>Planned Downtime</th>
                                                    <th>Loading Time</th>
                                                    <th>Failure & Repair</th>
                                                    <th>Setup & Adjustment</th>
                                                    <th>Operation Time</th>
                                                    <th>Availality Ratio</th>
                                                </tr>
                                                <tr>
                                                    {{-- data here --}}
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        const buttonHitung = $('#button-hitung');
        const buttonReset = $('#button-reset');
        const buttonSimpan = $('#button-simpan');
        const buttonLanjut = $('#button-lanjut');
    </script>
@endpush
