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
        Schema::create('users_subcircuits', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('subcircuit_id')->constrained('subcircuits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_roles', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['subcircuit_id']);
        });
        Schema::dropIfExists('users_subcircuits');
    }
};
