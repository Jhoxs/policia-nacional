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
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->foreignId('rol_id')->constrained('roles');
            $table->foreignId('permission_id')->constrained('permissions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles_permissions', function (Blueprint $table) {
            $table->dropForeign(['rol_id']);
            $table->dropForeign(['permission_id']);
        });
        Schema::dropIfExists('roles_permissions');
    }
};
