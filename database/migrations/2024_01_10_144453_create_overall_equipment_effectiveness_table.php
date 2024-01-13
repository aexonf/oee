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
             $table->foreign('availability_id')->references('id')->on('availability')->onDelete("CASCADE");

             $table->unsignedBigInteger('performance_id');
             $table->foreign('performance_id')->references('id')->on('performance')->onDelete("CASCADE");

             $table->unsignedBigInteger('quality_id');
             $table->foreign('quality_id')->references('id')->on('quality')->onDelete("CASCADE");


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
