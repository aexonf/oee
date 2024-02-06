<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AvailabilityController extends Controller
{
    public function index()
    {
        return view('pages.availability.index');
    }

    public function detail($id)
    {
        return view('pages.availability.detail', [
            "availabilityData" => Availability::find($id),
            "id" => $id
        ]);
    }

    public function update($id, Request $request)
    {
        $update = Availability::find($id);
        $update->update([
            "jam_kerja" => $request->jam_kerja,
            "jam_lembur" => $request->jam_lembur,
            "planned_downtime" => $request->planned_downtime,
            "loading_time" => $request->loading_time,
            "breakdown" => $request->breakdown,
            "setup_adjustment" => $request->setup_adjustment,
            "operation_time" => $request->operation_time,
            "availability_ratio" => $request->availability_ratio,
        ]);


        if ($update) {
            return redirect()->back()->with(["success" => "Berhasil update availability"]);
        }

        return redirect()->back()->with("error", "Gagal update availability");

    }

    /**
     * Menangani permintaan pembuatan data Availability.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->all());
        // Validasi input data
        $validasi = $request->validate([
            "jam_kerja" => "numeric",
            "jam_lembur" => "numeric",
            "planned_downtime" => "numeric",
            "loading_time" => "numeric",
            "breakdown" => "numeric",
            "setup_adjustment" => "numeric",
            "operation_time" => "numeric",
        ]);


        // Menambahkan hasil kalkulasi ke dalam array validasi
        $validasi["total_machine_working_times"] = $request->total_machine_working_times;
        $validasi["loading_time"] = $request->loading_time;
        $validasi["operation_time"] = $request->operation_time;
        $validasi["availability_ratio"] = $request->availability_ratio;
        $validasi["created_at"] = Carbon::now()->format('Y-m-d');

        // Menyimpan data ke database
        $create = Availability::create($validasi);

        // Memberikan feedback menggunakan flash message
        if ($create) {
            return redirect()->back()->with(["success" => "Berhasil membuat availability", "data" => $create]);
        }

        return redirect()->back()->with("error", "Gagal membuat availability");

    }

    public function delete($id)
    {
        // Availability::find($id)->delete();
        $availability = Availability::find($id);

        if ($availability) {
            $availability->delete();
        }
        return redirect()->back();
    }
}
