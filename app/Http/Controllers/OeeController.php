<?php

namespace App\Http\Controllers;

use App\Models\OverallEquipmentEffectiveness;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class OeeController extends Controller
{

    public function index(){
        $data_oee_weeks = [];


        foreach (CarbonPeriod::create(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()) as $date) {

        $data_oee_week = OverallEquipmentEffectiveness::whereDate('created_at', $date->toDateString())->get();

        array_push($data_oee_weeks, [
            "data" => $data_oee_week,
            "date" => $date->toDateString()
        ]);

        }

        $data_oee_weeks = collect($data_oee_weeks)->unique('data.*.created_at')->toJson();

        return view("pages.index", [
            "dataOee" => $data_oee_weeks,
            "data" => OverallEquipmentEffectiveness::with(["performance", "quality", "availability"])->get()
        ]);


    }


}
