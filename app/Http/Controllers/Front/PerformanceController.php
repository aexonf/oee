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
            "processed_amount" => "integer",
            "loading_time" => "integer",
            "ideal_cycle_time" => "integer",
            "operation_time" => "integer",
        ]);

        // Mendapatkan objek Availability berdasarkan ID
        $availability = Availability::find($id);

        // Menambahkan ID Availability ke dalam data validasi
        $validasi["availability_id"] = $availability->id;

        // Menghitung performance berdasarkan rumus yang diberikan
        $performance = ($validasi["jumlah_produksi"] * $validasi["ideal_cycle_time"]) / $validasi["operation_time"] * 100;

        // Menghitung cycle time berdasarkan rumus yang diberikan
        $cycleTime = ($validasi["loading_time"] / $validasi["processed_amount"]) * 100;

        // Menghitung ideal cycle time berdasarkan rumus yang diberikan
        $idealCycleTime = $cycleTime * $availability->jam_kerja;

        // Menambahkan hasil kalkulasi ke dalam array validasi
        $validasi["cycle_time"] = $cycleTime;
        $validasi["ideal_cycle_time"] = $idealCycleTime;
        $validasi["performance"] = $performance;

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
