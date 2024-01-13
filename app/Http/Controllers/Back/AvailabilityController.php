<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index()
    {
        return view('pages.availability.index', ["data" => Availability::all()]);
    }

    /**
     * Menangani permintaan pembuatan data Availability.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Validasi input data
        $validasi = $request->validate([
            "jam_kerja" => "integer",
            "jam_lembur" => "integer",
            "machine_working_times" => "integer",
            "planned_downtime" => "integer",
            "loading_time" => "integer",
            "failure_repair" => "integer",
            "setup_adjustment" => "integer",
            "operation_time" => "integer",
        ]);

        // Menambahkan hasil kalkulasi ke dalam array validasi
        $validasi["machine_working_times"] = $request->machine_working_times;
        $validasi["loading_time"] = $request->loading_time;
        $validasi["operation_time"] = $request->operation_time;
        $validasi["availability_ratio"] = $request->availability_ratio;

        // Menyimpan data ke database
        $create = Availability::create($validasi);

        // Memberikan feedback menggunakan flash message
        if ($create) {
            return redirect()->back()->with("success", "Berhasil membuat availability");
        } else {
            return redirect()->back()->with("error", "Gagal membuat availability");
        }
    }

    public function removeAll()
    {
        Availability::truncate();
        return redirect()->back();
    }
}
