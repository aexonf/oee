@extends('components.elements.app')

@section('title', 'OEE - Rate of Quality Product ')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Quality Product</h1>
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
                                <h5 class="col-12 mb-3">Quality</h5>
                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="jam_kerja">Reject saat Setup</label>
                                <input type="text" class="form-control col-3 mb-4" name="jam_kerja" id="jam_kerja">
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">unit</p>
                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="jam_kerja">Reject dan Rework</label>
                                <input type="text" class="form-control col-3 mb-4" name="jam_kerja" id="jam_kerja">
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">unit</p>
                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="jam_kerja">Jumlah Produksi</label>
                                <input type="text" class="form-control col-3 mb-4" name="jam_kerja" id="jam_kerja"
                                    disabled>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">unit</p>

                                <h5 class="col-12 mb-3">Rate of quality Product</h5>
                                <input type="text" class="form-control col-3 mb-4" name="jam_kerja" id="jam_kerja"
                                    disabled>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">%</p>
                                <h4 class="col-12 d-flex justify-content-start align-items-center mb-4 text-danger">
                                    * Target presentase rate of quality = 99%
                                </h4>

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
                            <div class="card">
                                <div class="card-header">
                                    <h4>Table</h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive overflow-x-auto">
                                        <table class="table table-striped table-md">
                                            <tbody>
                                                <tr>
                                                    <th>Jumlah Produksi</th>
                                                    <th>Reject saat Setup</th>
                                                    <th>Reject & Repair</th>
                                                    <th>Rate of Quality</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end my-5">
                                <a href="{{ route('performance', ['id' => 1]) }}" class="btn btn-primary ml-2"
                                    id="button-simpan">Kembali</a>
                                <a href="{{ route('oee') }}" class="btn btn-success ml-2" id="button-lanjut">Lanjut</a>
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
