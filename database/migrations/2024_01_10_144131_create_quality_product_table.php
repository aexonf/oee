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
        Schema::create('quality_product', function (Blueprint $table) {
            $table->id();
            $table->integer('reject_setup');
            $table->integer('reject_rework');
            $table->string('rate_of_quality_product');

            // relasi
            $table->unsignedBigInteger('performance_efficiency_id');
            $table->foreign('performance_efficiency_id')->references('id')->on('performance_efficiency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_product');
    }
};
