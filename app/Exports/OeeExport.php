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
       
        $oeeData = OverallEquipmentEffectiveness::with(["performance", "quality", "availability"])->get();

        return view('pages.format-export-oee', [
            "data" => $oeeData,
        ]);
    }


}
