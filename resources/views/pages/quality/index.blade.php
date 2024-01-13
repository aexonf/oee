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
                        <form class="needs-validation" method="POST" action="{{ route('quality.create', $id) }}">
                            @csrf
                            @method('POST')
                            <div class="form-group mb-2 row">
                                <h5 class="col-12 mb-3">Quality</h5>
                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="reject_setup">Reject saat Setup</label>
                                <input type="text" class="form-control col-3 mb-4" name="reject_setup" id="reject_setup">
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">unit</p>
                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="reject_rework">Reject dan Rework</label>
                                <input type="text" class="form-control col-3 mb-4" name="reject_rework"
                                    id="reject_rework">
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">unit</p>
                                <label class="col-2 col-form-label d-flex justify-content-center align-items-center mb-4"
                                    for="jumlah_produksi">Jumlah Produksi</label>
                                <input type="text" value="{{ $data->jumlah_produksi }}" class="form-control col-3 mb-4"
                                    name="jumlah_produksi" id="jumlah_produksi" readonly>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">unit</p>

                                <h5 class="col-2 d-flex justify-content-center align-items-center mb-3">Rate of quality
                                    Product</h5>
                                <input type="text" class="form-control col-3 mb-4" name="rate_of_quality_product"
                                    id="rate_of_quality_product" readonly>
                                <p class="col-1 d-flex justify-content-center align-items-center mb-4">%</p>
                                <h4 class="col-12 d-flex justify-content-start align-items-center mb-4 text-danger">
                                    * Target presentase rate of quality = 99%
                                </h4>
                                <h3 class="col-12" id="target_presentase_rate"></h3>

                            </div>
                            <div class="mt-5 d-flex justify-content-between">
                                <div>
                                    <button type="button" onclick="hitung()" class="btn btn-primary ml-2"
                                        id="button-hitung">Hitung</button>
                                    <a href="{{ route('quality', $id) }}" class="btn btn-danger ml-2 ">Reset</a>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary ml-2 " id="button-simpan"
                                        disabled>Simpan</button>
                        </form>

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
                                        <th>Reject & Rework</th>
                                        <th>Rate of Quality</th>
                                        <th>Action</th>
                                    </tr>
                                    @if ($quality)
                                        <tr>
                                            <td>
                                                {{ $quality->jumlah_produksi }}
                                            </td>
                                            <td>
                                                {{ $quality->reject_setup }}
                                            </td>
                                            <td>
                                                {{ $quality->reject_rework }}
                                            </td>
                                            <td>
                                                {{ $quality->rate_of_quality_product }}
                                            </td>
                                            <td class="d-flex">
                                                <a href="{{ route('oee', $quality->id) }}" class="btn btn-success ml-2"
                                                    id="button-lanjut">Lanjut</a>
                                                <form action="{{ route('quality.delete', $quality->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger ml-2 "
                                                        id="button-hapus-semua">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end my-5">
                    <a href="{{ route('performance', ['id' => 1]) }}" class="btn btn-primary ml-2"
                        id="button-simpan">Kembali</a>
                </div>
            </div>
    </div>
    </div>
    </section>
    </div>

    <script>
        function hitung() {
            // Get input values
            const rejectSetup = parseFloat(document.getElementById('reject_setup').value) || 0;
            const rejectRework = parseFloat(document.getElementById('reject_rework').value) || 0;
            const jumlahProduksi = parseInt(document.getElementById('jumlah_produksi').value) || 0;

            // Calculate rate of quality product
            const rateOfQualityProduct = ((jumlahProduksi - rejectSetup - rejectRework) / jumlahProduksi) * 100;
            document.getElementById('rate_of_quality_product').value = rateOfQualityProduct.toFixed(5);


            const badgeContainer = document.getElementById('target_presentase_rate');

            // Clear previous badges
            badgeContainer.innerHTML = '';

            if (rateOfQualityProduct >= 95) {
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
