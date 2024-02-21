<?php

namespace App\Exports;

use App\Models\OverallEquipmentEffectiveness;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Facades\Excel;

class OeeExport implements  FromView, ShouldAutoSize
{
   /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        // Mengambil data 1 minggu terakhir
    //    $endDate = Carbon::now();
      //  $startDate = $endDate->copy()->subWeek();

        // Mengambil semua data
        $oeeData = OverallEquipmentEffectiveness::with(["performance", "quality", "availability"])->get();

        // Menghitung jumlah hari dalam rentang waktu data yang diambil
       // $daysInRange = $endDate->diffInDays($startDate) + 1;

        // Menghitung rata-rata OEE per hari
      //  $totalOee = $oeeData->sum('oee');
        //$averageOeePerDay = $totalOee / $daysInRange;

        // Mengalikan setiap nilai OEE dengan rasio hari dalam seminggu dan jumlah hari data yang ada
        //$oeeData->transform(function ($item) use ($daysInRange, $averageOeePerDay) {
          //  $item->oee = $item->oee * (7 / $daysInRange);
            //return $item;
        //});

        return view('pages.format-export-oee', [
            "data" => $oeeData,
        ]);
    }


}
