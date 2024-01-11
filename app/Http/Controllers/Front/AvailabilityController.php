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
        return view('');
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
            "breakdown" => "integer",
            "planned_downtime" => "integer",
            "loading_time" => "integer",
            "setup_adjustment" => "integer",
            "operation_time" => "integer",
        ]);

        // Kalkulasi planned downtime
        $planned_downtime = $validasi["breakdown"] + $validasi["setup_adjustment"];

        // Kalkulasi loading time
        $loading_time = $validasi["jam_kerja"] - $planned_downtime;

        // Kalkulasi operation time
        $operation_time = $loading_time - $planned_downtime;

        // Kalkulasi availability
        $availability = ($operation_time / $loading_time) * 100;

        // Menambahkan hasil kalkulasi ke dalam array validasi
        $validasi["planned_downtime"] = $planned_downtime;
        $validasi["loading_time"] = $loading_time;
        $validasi["operation_time"] = $operation_time;
        $validasi["availability"] = $availability;


        // menyimpan ke database
        $create = Availability::create($validasi);

        // mengecek jika create berhasil atau gagal

        if ($create) {
            Session::flash("success", "Berhasil membuat availability");
        }

        Session::flash("error", "Gagal membuat availability");
        return redirect()->back();
    }
}
