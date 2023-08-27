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
        Schema::create('contract_spare', function (Blueprint $table) {
            $table->foreignId('contract_id')->constrained('contracts');
            $table->foreignId('spare_id')->constrained('spares');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contract_spare', function (Blueprint $table) {
            $table->dropForeign(['contract_id']);
            $table->dropForeign(['spare_id']);
        });
        Schema::dropIfExists('contract_spare');
    }
};
