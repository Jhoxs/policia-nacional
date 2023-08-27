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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->integer('status')->default(0);
            $table->boolean('in_progress')->default(0);
            $table->date('shift_date')->nullable();
            $table->time('shift_time_from',0)->nullable();
            $table->time('shift_time_to',0)->nullable();
            $table->string('shift_time_range')->nullable();
            $table->text('description')->nullable();
            $table->text('reason_reject')->nullable();
            $table->foreignId('record_start_maintenance_id')->nullable()->constrained('record_start_maintenances');
            $table->foreignId('record_end_maintenance_id')->nullable()->constrained('record_end_maintenances');
            $table->decimal('price', $precision = 8, $scale = 2)->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenances', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['record_start_maintenance_id']);
            $table->dropForeign(['record_end_maintenances_id']);
        });
        Schema::dropIfExists('maintenances');
    }
};
