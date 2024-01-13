<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\OverallEquipmentEffectiveness;
use App\Models\Performance;
use App\Models\Quality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OeeController extends Controller
{

    public function index(Request $request, $id){
        $quality = Quality::find($id);
        $performance = Performance::where("availability_id", $quality->performance_id)->first();
        $availability = Availability::find($performance->availability_id);
        return view("pages.oee.index", [
            "quality" => $quality,
            "performance" => $performance,
            "availability" => $availability,
        ]);
    }

    public function create($qid, $pid, $aid){

        $create  = OverallEquipmentEffectiveness::create([
            "availability_id" => $aid,
            "performance_id" => $pid,
            "quality_id" => $qid,
        ]);

        if ($create) {
            Session::flash("success", "Berhasil membuat data performance");
        } else {
            Session::flash("error", "Gagal membuat data performance");
        }

        // Kembali ke halaman sebelumnya
        return redirect("/");
    }

}
