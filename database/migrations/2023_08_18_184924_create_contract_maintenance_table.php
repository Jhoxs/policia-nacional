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
        Schema::create('contract_maintenance', function (Blueprint $table) {
            $table->foreignId('contract_id')->constrained('contracts');
            $table->foreignId('maintenance_id')->constrained('maintenances');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contract_maintenance', function (Blueprint $table) {
            $table->dropForeign(['contract_id']);
            $table->dropForeign(['maintenance_id']);
        });
        Schema::dropIfExists('contract_maintenance');
    }
};
