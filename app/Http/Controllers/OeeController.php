<?php

namespace App\Http\Controllers;

use App\Exports\OeeExport;
use App\Models\Availability;
use App\Models\OverallEquipmentEffectiveness;
use App\Models\Performance;
use App\Models\Quality;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class OeeController extends Controller
{

    public function index(Request $request)
    {
        $data_oee_weeks = [];

        $from = $request->query("from");
        $to = $request->query("to");

        $oeeQuery = OverallEquipmentEffectiveness::with(["performance", "availability", "quality"]);

        if ($request->has('from') && $request->has('to')) {
            $oeeQuery->whereBetween('created_at', [$from, $to]);
        }

        if ($request->has("from") && $request->has("to")) {
            $data_oee_week = $oeeQuery->whereBetween('created_at', [$from, $to])->get();
            foreach (CarbonPeriod::create(Carbon::parse($from)->startOfWeek(), Carbon::parse($to)->endOfWeek()) as $date) {
                array_push($data_oee_weeks, [
                    "date" => $date->toDateString(),
                    "data" => $data_oee_week,
                ]);
            }
        } else {
            foreach (CarbonPeriod::create(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()) as $date) {
                $data_oee_week = $oeeQuery->whereDate('created_at', $date->toDateString())->get();
                array_push($data_oee_weeks, [
                    "date" => $date->toDateString(),
                    "data" => $data_oee_week,
                ]);
            }
        }


        $data_oee_weeks = collect($data_oee_weeks);

        return view("pages.index", [
            "dataOee" => $data_oee_weeks,
            "data" => $oeeQuery->get()
        ]);
    }


    public function deleteOee($id)
    {
        $oee = OverallEquipmentEffectiveness::find($id);

        if ($oee) {
            $avaibility = Availability::find($oee->availability_id);
            $performance = Performance::find($oee->performance_id);
            $quality = Quality::find($oee->quality_id);

            if ($avaibility && $performance && $quality) {
                $avaibilityDeleted = $avaibility->delete();
                $performanceDeleted = $performance->delete();
                $qualityDeleted = $quality->delete();

                if ($avaibilityDeleted && $performanceDeleted && $qualityDeleted) {
                    Session::flash('success', 'Data berhasil dihapus.');
                } else {
                    Session::flash('error', 'Gagal menghapus data. Terjadi kesalahan dalam menghapus.');
                }
            } else {
                Session::flash('error', 'Gagal menghapus data. Salah satu data terkait tidak ditemukan.');
            }
        } else {
            Session::flash('error', 'Gagal menghapus data. Data tidak ditemukan.');
        }
    }

    public function export()
    {
        return Excel::download(new OeeExport, 'oee.xlsx');
    }

}
