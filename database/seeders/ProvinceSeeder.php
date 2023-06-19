<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Province::factory()->create([
            'name' => 'azuay',
            'display_name' => 'Azuay',
        ]);
        Province::factory()->create([
            'name' => 'bolivar',
            'display_name' => 'Bolívar',
        ]);
        Province::factory()->create([
            'name' => 'caniar',
            'display_name' => 'Cañar',
        ]);
        Province::factory()->create([
            'name' => 'carchi',
            'display_name' => 'Carchi',
        ]);
        Province::factory()->create([
            'name' => 'chimborazo',
            'display_name' => 'Chimborazo',
        ]);
        Province::factory()->create([
            'name' => 'cotopaxi',
            'display_name' => 'Cotopaxi',
        ]);
        Province::factory()->create([
            'name' => 'el_oro',
            'display_name' => 'El Oro',
        ]);
        Province::factory()->create([
            'name' => 'esmeraldas',
            'display_name' => 'Esmeraldas',
        ]);
        Province::factory()->create([
            'name' => 'galapagos',
            'display_name' => 'Galápagos',
        ]);
        Province::factory()->create([
            'name' => 'guayas',
            'display_name' => 'Guayas',
        ]);
        Province::factory()->create([
            'name' => 'imbabura',
            'display_name' => 'Imbabura',
        ]);
        Province::factory()->create([
            'name' => 'loja',
            'display_name' => 'Loja',
        ]);
        Province::factory()->create([
            'name' => 'los_rios',
            'display_name' => 'Los Ríos',
        ]);
        Province::factory()->create([
            'name' => 'manabi',
            'display_name' => 'Manabí',
        ]);
        Province::factory()->create([
            'name' => 'morona_santiago',
            'display_name' => 'Morona Santiago',
        ]);
        Province::factory()->create([
            'name' => 'napo',
            'display_name' => 'Napo',
        ]);
        Province::factory()->create([
            'name' => 'orellana',
            'display_name' => 'Orellana',
        ]);
        Province::factory()->create([
            'name' => 'pastaza',
            'display_name' => 'Pastaza',
        ]);
        Province::factory()->create([
            'name' => 'pichincha',
            'display_name' => 'Pichincha',
        ]);
        Province::factory()->create([
            'name' => 'santa_elena',
            'display_name' => 'Santa Elena',
        ]);
        Province::factory()->create([
            'name' => 'santo_domingo',
            'display_name' => 'Santo Domingo de los Tsáchilas',
        ]);
        Province::factory()->create([
            'name' => 'sucumbios',
            'display_name' => 'Sucumbíos',
        ]);
        Province::factory()->create([
            'name' => 'tungurahua',
            'display_name' => 'Tungurahua',
        ]);
        Province::factory()->create([
            'name' => 'zamora_chinchipe',
            'display_name' => 'Zamora Chinchipe',
        ]);
    }
}
