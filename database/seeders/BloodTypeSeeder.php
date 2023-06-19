<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BloodType;

class BloodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BloodType::factory()->create([
                'name' => 'a_plus',
                'display_name' => 'A +',
        ]);
        BloodType::factory()->create([
                'name' => 'a_less',
                'display_name' => 'A -',
        ]);
        BloodType::factory()->create([
                'name' => 'b_plus',
                'display_name' => 'B +',
        ]);
        BloodType::factory()->create([
                'name' => 'b_less',
                'display_name' => 'B -',
        ]);
        BloodType::factory()->create([
                'name' => 'ab_plus',
                'display_name' => 'AB +',
        ]);
        BloodType::factory()->create([
                'name' => 'ab_less',
                'display_name' => 'AB -',
        ]);
        BloodType::factory()->create([
                'name' => 'o_plus',
                'display_name' => 'O +',
        ]);
        BloodType::factory()->create([
                'name' => 'o_less',
                'display_name' => 'O -',
        ]);
        
    }
}
