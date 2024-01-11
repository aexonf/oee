<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\Performance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PerformanceController extends Controller
{

    public function index()
    {
        return view('');
    }

    /**
     * Menangani permintaan pembuatan data Performance berdasarkan Availability.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id ID Availability yang terkait dengan data Performance
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        // Validasi input data
        $validasi = $request->validate([
            "cycle_time" => "integer",
            "jumlah_produksi" => "integer",
            "target_produksi" => "integer",
            "actual_cycle_time" => "integer",
        ]);

        // Mendapatkan objek Availability berdasarkan ID
        $availability = Availability::find($id);

        // Menghitung target produksi berdasarkan rumus yang diberikan
        $targetProduksi = $availability->operation_time / $validasi["cycle_time"];

        // Menghitung actual cycle time berdasarkan rumus yang diberikan
        $actualCycleTime = $availability->operation_time / $validasi["jumlah_produksi"];

        // Menghitung performance efficiency berdasarkan rumus yang diberikan
        $performance = $validasi["jumlah_produksi"] * $validasi["cycle_time"] / $availability->operation_time * 100;

        // Menambahkan hasil kalkulasi ke dalam array validasi
        $validasi["target_produksi"] = $targetProduksi;
        $validasi["actual_cycle_time"] = $actualCycleTime;
        $validasi["performance_efficiency"] = $performance;

        // Membuat data Performance dengan menggunakan model dan data validasi
        $create = Performance::create($validasi);

        // Memberikan feedback menggunakan flash message
        if ($create) {
            Session::flash("success", "Berhasil membuat data performance");
        } else {
            Session::flash("error", "Gagal membuat data performance");
        }

        // Kembali ke halaman sebelumnya
        return redirect()->back();
    }
}
