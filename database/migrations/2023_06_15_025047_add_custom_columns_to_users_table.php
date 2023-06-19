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
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->after('name');
            $table->string('identification')->unique()->after('last_name');
            $table->string('phone')->unique()->nullable()->after('identification');
            $table->date('birthdate')->after('phone');
            $table->foreignId('city_id')->after('birthdate')->constrained('cities');
            $table->foreignId('blood_type_id')->after('city_id')->constrained('blood_types');
            $table->foreignId('rank_id')->after('blood_type_id')->constrained('ranks');
            $table->softDeletes()->after('updated_at');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['blood_type_id']);
            $table->dropForeign(['rank_id']);
            $table->dropColumn(['last_name', 'identification', 'phone','birthdate','city_id','blood_type_id','rank_id']);
        });
    }
};
