<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\Quality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QualityController extends Controller
{

    public function index(){
        return view('');
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
        "processed_amount" => "integer",
        "defect_amount" => "integer",
    ]);

    // Mendapatkan objek Performance berdasarkan ID
    $performance = Performance::find($id);

    // Menghitung jumlah produk yang berhasil diproses (tanpa cacat)
    $processedAmount = $validasi["processed_amount"] - $validasi["defect_amount"];

    // Menghitung persentase kualitas berdasarkan produk yang berhasil diproses
    $quality = $processedAmount * 100;

    // Menambahkan hasil kalkulasi ke dalam array validasi
    $validasi["quality"] = $quality;
    $validasi["performance_id"] = $performance->id;

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


}
