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
                <h1>Performance</h1>
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
                        <form class="needs-validation" method="get" action="#">
                            @csrf
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
                                <input type="text" class="form-control col-3 mb-4" name="target_produksi"
                                    id="target_produksi" disabled>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">unit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="actual_cycle_time">Actual Cycle time <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3 mb-4" name="actual_cycle_time"
                                    id="actual_cycle_time" disabled>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">menit / unit</p>

                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="jam_kerja">Operation Time <span class="text-danger">*</span></label>
                                <input type="text" class="form-control col-3 mb-4" name="jam_kerja" id="jam_kerja"
                                    disabled>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">menit</p>

                                <h5 class="col-12 mb-3">Performance</h5>
                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="jam_kerja">Performance Efficiency</label>
                                <input type="text" class="form-control col-3 mb-4" name="jam_kerja" id="jam_kerja"
                                    disabled>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">menit</p>

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
                                    <button type="submit" class="btn btn-danger ml-2 disabled" id="button-hapus-semua"
                                        disabled>Hapus Semua</button>
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="d-flex justify-content-end my-5">
                            {{-- dapetin id nya --}}
                            <a href='{{ route('availability', ['id' => 1]) }}' class="btn btn-primary ml-2"
                                id="button-simpan">Kembali</a>
                            <a href="{{ route('quality', ['id' => 1]) }}" class="btn btn-success ml-2"
                                id="button-lanjut">Lanjut</a>
                        </div>
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
