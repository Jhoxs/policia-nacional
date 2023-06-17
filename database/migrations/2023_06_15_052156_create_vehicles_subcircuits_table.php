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
        Schema::create('vehicles_subcircuits', function (Blueprint $table) {
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->foreignId('subcircuit_id')->constrained('subcircuits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles_subcircuits', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['subcircuit_id']);
        });
        Schema::dropIfExists('vehicles_subcircuits');
    }
};
