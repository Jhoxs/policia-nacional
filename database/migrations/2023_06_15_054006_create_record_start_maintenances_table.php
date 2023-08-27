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
        Schema::create('record_start_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->foreignId('user_id')->constrained('users');
            $table->string('img_vehicle')->nullable();
            $table->string('signature_responsibility');
            $table->text('detail')->nullable();
            $table->timestamp('admission_date');
            $table->integer('current_mileage');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('record_start_maintenances', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('record_start_maintenances');
    }
};
