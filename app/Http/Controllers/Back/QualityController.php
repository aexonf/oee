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
        return view('pages.quality.index', ["data" => Performance::find($id), "id" => $id, "quality" => Quality::with('performance')->where('performance_id', $id)->first()]);
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

        $validasi["rate_of_quality_product"] = $request->rate_of_quality_product;
        $validasi["jumlah_produksi"] = $request->jumlah_produksi;
        $validasi["performance_id"] = $id;

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

    public function remove($id)
    {
        Quality::where("performance_id", $id)->first()->delete();
        return redirect()->back();
    }
}
