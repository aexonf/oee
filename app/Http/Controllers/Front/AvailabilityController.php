<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AvailabilityController extends Controller
{
    public function index()
    {
        return view(''); // Make sure to provide the correct view name
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

        // Menghitung total waktu kerja mesin (jam kerja + jam lembur)
        $machineWorkingTimes = $validasi["jam_kerja"] + $validasi["jam_lembur"];

        // Menghitung waktu loading (total waktu kerja - downtime terjadwal)
        $loadingTime = $machineWorkingTimes - $validasi["planned_downtime"];

        // Menghitung waktu operasi (waktu loading - waktu failure repair - waktu setup adjustment)
        $operationTime = $loadingTime - $validasi["failure_repair"] - $validasi["setup_adjustment"];

        // Menghitung rasio ketersediaan (selisih waktu loading dengan loading time, diubah ke persen)
        $availabilityRatio = ($loadingTime - $validasi["loading_time"]) / $loadingTime * 100;

        // Menambahkan hasil kalkulasi ke dalam array validasi
        $validasi["machine_working_times"] = $machineWorkingTimes;
        $validasi["loading_time"] = $loadingTime;
        $validasi["operation_time"] = $operationTime;
        $validasi["availability_ratio"] = $availabilityRatio;

        // Menyimpan data ke database
        $create = Availability::create($validasi);

        // Memberikan feedback menggunakan flash message
        if ($create) {
            return redirect()->back()->with("success", "Berhasil membuat availability");
        } else {
            return redirect()->back()->with("error", "Gagal membuat availability");
        }
    }
    
}
