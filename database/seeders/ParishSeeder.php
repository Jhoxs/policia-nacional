<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parish;

class ParishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Parish::factory()->create([
            'code' => '11D03',
            'name' => 'vilcabamba',
            'display_name' => 'Vilcabamba',
            'city_id' => 12
        ]);
        Parish::factory()->create([
            'code' => '11D04',
            'name' => 'quinara',
            'display_name' => 'Quinara',
            'city_id' => 12
        ]);
        Parish::factory()->create([
            'code' => '11D05',
            'name' => 'malacatos',
            'display_name' => 'Malacatos',
            'city_id' => 12
        ]);
        Parish::factory()->create([
            'code' => '11D06',
            'name' => 'chuquiribamba',
            'display_name' => 'Chuquiribamba',
            'city_id' => 12
        ]);
        Parish::factory()->create([
            'code' => '11D07',
            'name' => 'Taquil',
            'display_name' => 'Taquil',
            'city_id' => 12
        ]);
        Parish::factory()->create([
            'code' => '11D01',
            'name' => 'loja',
            'display_name' => 'Loja',
            'city_id' => 12
        ]);
        Parish::factory()->create([
            'code' => '11D08',
            'name' => 'el_tambo',
            'display_name' => 'El Tambo',
            'city_id' => 13
        ]);
        Parish::factory()->create([
            'code' => '11D02',
            'name' => 'Catamayo',
            'display_name' => 'Catamayo',
            'city_id' => 13
        ]);
        Parish::factory()->create([
            'code' => '11D09',
            'name' => 'zambi',
            'display_name' => 'Zambi',
            'city_id' => 13
        ]);
        Parish::factory()->create([
            'code' => '11D10',
            'name' => 'san_pedro_de_la_bendita',
            'display_name' => 'San Pedro de la Bendita',
            'city_id' => 13
        ]);
        Parish::factory()->create([
            'code' => '11D11',
            'name' => 'chaguarpamba',
            'display_name' => 'Chaguarpamba',
            'city_id' => 13
        ]);
    }
}
