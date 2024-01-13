<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\Performance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PerformanceController extends Controller
{

    public function index($id)
    {
        return view('pages.performance.index', [
            "data" => Availability::find($id),
            "id" => $id,
            "performance" => Performance::with('availability')->where("availability_id", $id)->first()
        ]);
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
        $validasi = $request->validate([
            "cycle_time" => "numeric",
            "jumlah_produksi" => "numeric",
            "target_produksi" => "numeric",
            "actual_cycle_time" => "numeric",
            "operation_time" => "numeric"
        ]);

        $validasi["target_produksi"] = $request->target_produksi;
        $validasi["actual_cycle_time"] = $request->actual_cycle_time;
        $validasi["performance_efficiency"] = $request->performance_efficiency;
        $validasi["availability_id"] = $id;

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

    public function remove($id)
    {
        Performance::where("availability_id", $id)->first()->delete();
        return redirect()->back();
    }
}
