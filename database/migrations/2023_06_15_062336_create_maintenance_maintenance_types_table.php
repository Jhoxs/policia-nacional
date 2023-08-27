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
        Schema::create('maintenance_maintenance_type', function (Blueprint $table) {
            $table->foreignId('maintenance_id')->constrained('maintenances');
            $table->foreignId('maintenance_type_id')->constrained('maintenance_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_maintenance_type', function (Blueprint $table) {
            $table->dropForeign(['maintenance_id']);
            $table->dropForeign(['maintenance_type_id']);
        });
        Schema::dropIfExists('maintenance_maintenance_type');
    }
};
