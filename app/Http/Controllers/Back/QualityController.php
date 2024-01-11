<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Performance;
use App\Models\Quality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QualityController extends Controller
{

    public function index($id)
    {
        return view('pages.availability.index', ["data" => Quality::find($id)]);
    }


    /**
     * Menangani permintaan pembuatan data Quality berdasarkan Performance.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id ID Performance yang terkait dengan data Quality
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        // Validasi input data
        $validasi = $request->validate([
            "reject_setup" => "integer",
            "reject_rework" => "integer",
        ]);

        // Mendapatkan objek Performance berdasarkan ID
        $performance = Performance::find($id);

        $rateOfQualityProduct = ($performance->jumlah_produksi - $validasi["reject_setup"] - $validasi["reject_rework"]) / $performance->jumlah_produksi * 100;
        $validasi["rate_of_quality_product"] = $rateOfQualityProduct;

        // Membuat data Quality dengan menggunakan model dan data validasi
        $create = Quality::create($validasi);

        // Memberikan feedback menggunakan flash message
        if ($create) {
            Session::flash("success", "Berhasil membuat data quality");
        } else {
            Session::flash("error", "Gagal membuat data quality");
        }

        // Kembali ke halaman sebelumnya
        return redirect()->back();
    }

    public function removeAll()
    {
        Quality::truncate();
        return redirect()->back();
    }

}
