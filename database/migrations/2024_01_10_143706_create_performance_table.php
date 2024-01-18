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
        Schema::create('performance', function (Blueprint $table) {
            $table->id();
            $table->string('jumlah_produksi');
            $table->string('processed_amount');
            $table->string('cycle_time');
            $table->string('performance_efficiency');
            // relasi
            $table->unsignedBigInteger('availability_id');
            $table->foreign('availability_id')->references('id')->on('availability')->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance');
    }
};
