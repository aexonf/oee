<?php

namespace App\Http\Controllers;

use App\Models\OverallEquipmentEffectiveness;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class OeeController extends Controller
{

    public function index()
    {
        $data_oee_weeks = [];


        foreach (CarbonPeriod::create(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()) as $date) {

            $data_oee_week = OverallEquipmentEffectiveness::with(["performance", "availability", "quality"])->where('created_at', $date->toDateString())->get();

            /*
                 rumus rata rata hasil semua oee di bagi jumlah oee
            */

            $averageOee = $data_oee_week->avg(function ($item) {
                return ($item->availability->availability_ratio + $item->performance->performance_efficiency + $item->quality->rate_of_quality_product) / $item->count();
            });


            $roundedAverageOee = round($averageOee); 

            array_push($data_oee_weeks, [
                "date" => $date->toDateString(),
                "averageOee" => $roundedAverageOee,
                "data" => $data_oee_week,
            ]);
        }



        $data_oee_weeks = collect($data_oee_weeks);

        return view("pages.index", [
            "dataOee" => $data_oee_weeks,
            "data" => OverallEquipmentEffectiveness::with(["performance", "quality", "availability"])->get()
        ]);
    }
}
