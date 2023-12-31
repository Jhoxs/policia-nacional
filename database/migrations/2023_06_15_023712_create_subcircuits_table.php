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
        Schema::create('subcircuits', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->string('display_name')->unique();
            $table->foreignId('circuit_id')->constrained('circuits');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subcircuits', function (Blueprint $table) {
            $table->dropForeign(['circuit_id']);
        });
        Schema::dropIfExists('subcircuits');
    }
};
