<?php

use App\Http\Controllers\Back\AvailabilityController;
use App\Http\Controllers\Back\PerformanceController;
use App\Http\Controllers\Back\QualityController;
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

Route::get('/', function () {
    return view('pages.index');
});



Route::prefix('/admin')->group(function() {


    Route::controller(AvailabilityController::class)->prefix("/availability")->group(function () {
        Route::get("/", 'index')->name("availability");
        Route::post("/", 'create')->name("availability.create");
    });

    Route::controller(PerformanceController::class)->prefix("/performance")->group(function () {
        Route::get("/{id}", 'index')->name("performance");
    });

    Route::controller(QualityController::class)->prefix("/quality")->group(function () {
        Route::get("/", 'index')->name("quality");
    });
    Route::get("/oee", function () {
        return view('pages.oee.index');
    })->name("oee");

});
