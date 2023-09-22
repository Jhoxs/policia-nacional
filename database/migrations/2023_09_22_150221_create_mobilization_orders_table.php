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
        Schema::create('mobilization_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('driver_id')->constrained('users');
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->integer('status')->default(0);
            $table->boolean('in_progress')->default(0);
            $table->time('departure_time');
            $table->date('departure_date');
            $table->text('reason');
            $table->text('reason_reject');
            $table->text('rute');
            $table->integer('current_mileage');
            $table->string('passengers')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mobilization_orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['driver_id']);
        });
        Schema::dropIfExists('mobilization_orders');
    }
};
