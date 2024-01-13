<?php

use App\Http\Controllers\Back\AvailabilityController;
use App\Http\Controllers\Back\OeeController;
use App\Http\Controllers\Back\PerformanceController;
use App\Http\Controllers\Back\QualityController;
use App\Models\OverallEquipmentEffectiveness;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware('auth')->prefix('/admin')->group(function() {
    Route::get('/', function () {
        return view('pages.index', ["data" => OverallEquipmentEffectiveness::with(["performance", "quality", "availability"])->get()]);
    });

    Route::controller(AvailabilityController::class)->prefix("/availability")->group(function () {
        Route::get("/", 'index')->name("availability");
        Route::post("/", 'create')->name("availability.create");
    });

    Route::controller(PerformanceController::class)->prefix("/performance")->group(function () {
        Route::get("/{id}", 'index')->name("performance");
        Route::post("/create/{id}", 'create')->name("performance.create");
        Route::delete("/{id}", 'remove')->name("performance.delete");
    });

    Route::controller(QualityController::class)->prefix("/quality")->group(function () {
        Route::get("/{id}", 'index')->name("quality");
        Route::post("/{id}", 'create')->name("quality.create");
        Route::delete("/{id}", 'remove')->name("quality.delete");
    });

    Route::controller(OeeController::class)->prefix("/oee")->group(function () {
        Route::get("/{id}", 'index')->name("oee");
        Route::post("/create/{qid}/{pid}/{aid}", 'create')->name("oee.create");
    });

});
require __DIR__.'/auth.php';
