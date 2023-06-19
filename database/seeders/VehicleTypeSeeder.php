<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VehicleType;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleType::factory()->create([
            'name' => 'auto',
            'display_name' => 'Auto',
        ]);
        VehicleType::factory()->create([
            'name' => 'motocicleta',
            'display_name' => 'Motocicleta',
        ]);
        VehicleType::factory()->create([
            'name' => 'camioneta',
            'display_name' => 'Camioneta',
        ]);
    }
}
