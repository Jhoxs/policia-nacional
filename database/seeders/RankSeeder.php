<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rank;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rank::factory()->create([
            'name' => 'general_superior',
            'display_name' => 'General Superior',
        ]);
        Rank::factory()->create([
            'name' => 'general_inspector',
            'display_name' => 'General Inspector',
        ]);
        Rank::factory()->create([
            'name' => 'general_de_distrito',
            'display_name' => 'General de Distrito',
        ]);
        Rank::factory()->create([
            'name' => 'coronel_de_policia',
            'display_name' => 'Coronel de Policía',
        ]);
        Rank::factory()->create([
            'name' => 'teniente_coronel_de_policia',
            'display_name' => 'Teniente Coronel de Polica',
        ]);
        Rank::factory()->create([
            'name' => 'mayor_de_policia',
            'display_name' => 'Mayor de Policía',
        ]);
        Rank::factory()->create([
            'name' => 'capitan_de_policia',
            'display_name' => 'Capitán de Policía',
        ]);
        Rank::factory()->create([
            'name' => 'teniente_de_policia',
            'display_name' => 'Teniente de Policía',
        ]);
        Rank::factory()->create([
            'name' => 'subteniente_de_policia',
            'display_name' => 'Subteniente de Policía',
        ]);
        Rank::factory()->create([
            'name' => 'suboficial_mayor',
            'display_name' => 'Suboficial Mayor',
        ]);
        Rank::factory()->create([
            'name' => 'suboficial_primero',
            'display_name' => 'Suboficial Primero',
        ]);
        Rank::factory()->create([
            'name' => 'suboficial_segundo',
            'display_name' => 'Suboficial Segundo',
        ]);
        Rank::factory()->create([
            'name' => 'sargento_primero',
            'display_name' => 'Sargento Primero',
        ]);
        Rank::factory()->create([
            'name' => 'sargento_segundo',
            'display_name' => 'Sargento Segundo',
        ]);
        Rank::factory()->create([
            'name' => 'cabo_primero',
            'display_name' => 'Cabo Primero',
        ]);
        Rank::factory()->create([
            'name' => 'cabo_segundo',
            'display_name' => 'Cabo Segundo',
        ]);
        Rank::factory()->create([
            'name' => 'policia',
            'display_name' => 'Policía',
        ]);
    }
}
