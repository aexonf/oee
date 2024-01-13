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
        Schema::create('quality', function (Blueprint $table) {
            $table->id();
            $table->string('reject_setup');
            $table->string('reject_rework');
            $table->string('jumlah_produksi');
            $table->string('rate_of_quality_product');

            // relasi
            $table->unsignedBigInteger('performance_id');
            $table->foreign('performance_id')->references('id')->on('performance')->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality');
    }
};
