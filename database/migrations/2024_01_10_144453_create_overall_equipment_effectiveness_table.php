<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('overall_equipment_effectiveness', function (Blueprint $table) {
            $table->id();
             // relasi
             $table->unsignedBigInteger('availability_id');
             $table->foreign('availability_id')->references('id')->on('availability');

             $table->unsignedBigInteger('performance_efficiency_id');
             $table->foreign('performance_efficiency_id')->references('id')->on('performance_efficiency');

             $table->unsignedBigInteger('quality_product_id');
             $table->foreign('quality_product_id')->references('id')->on('quality_product');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overall_equipment_effectiveness');
    }
};
