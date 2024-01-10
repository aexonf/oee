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
        Schema::create('availability', function (Blueprint $table) {
            $table->id();
            $table->integer('jam_kerja');
            $table->integer("jam_lembur");
            $table->integer("machine_working_times");
            $table->integer("planned_downtime");
            $table->integer("loading_time");
            $table->integer("failure_repair");
            $table->integer("setup_adjustment");
            $table->integer("operation_time");
            $table->string("availability_ratio");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availability');
    }
};
