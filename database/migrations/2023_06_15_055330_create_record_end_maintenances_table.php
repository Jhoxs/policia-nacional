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
        Schema::create('record_end_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->text('detail')->nullable();
            $table->integer('next_mileage')->nullable();
            $table->timestamp('departure_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('record_end_maintenances', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
        });
        Schema::dropIfExists('record_end_maintenances');
    }
};
