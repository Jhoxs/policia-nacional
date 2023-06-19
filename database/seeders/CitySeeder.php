<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::factory()->create([
            'name' => 'cuenca',
            'display_name' => 'Cuenca',
            'province_id' => 1
        ]);
        City::factory()->create([
            'name' => 'guaranda',
            'display_name' => 'Guaranda',
            'province_id' => 2
        ]);
        City::factory()->create([
            'name' => 'azogues',
            'display_name' => 'Azogues',
            'province_id' => 3
        ]);
        City::factory()->create([
            'name' => 'tulcan',
            'display_name' => 'Tulcán',
            'province_id' => 4
        ]);
        City::factory()->create([
            'name' => 'riobamba',
            'display_name' => 'Riobamba',
            'province_id' => 5
        ]);
        City::factory()->create([
            'name' => 'latacunga',
            'display_name' => 'Latacunga',
            'province_id' => 6
        ]);
        City::factory()->create([
            'name' => 'machala',
            'display_name' => 'Machala',
            'province_id' => 7
        ]);
        City::factory()->create([
            'name' => 'esmeraldas',
            'display_name' => 'Esmeraldas',
            'province_id' => 8
        ]);
        City::factory()->create([
            'name' => 'puerto_baquerizo_moreno',
            'display_name' => 'Puerto Baquerizo Moreno',
            'province_id' => 9
        ]);
        City::factory()->create([
            'name' => 'guayaquil',
            'display_name' => 'Guayaquil',
            'province_id' => 10
        ]);
        City::factory()->create([
            'name' => 'ibarra',
            'display_name' => 'Ibarra',
            'province_id' => 11
        ]);
        City::factory()->create([
            'name' => 'loja',
            'display_name' => 'Loja',
            'province_id' => 12
        ]);
        City::factory()->create([
            'name' => 'catamayo',
            'display_name' => 'Catamayo',
            'province_id' => 12
        ]);
        City::factory()->create([
            'name' => 'babahoyo',
            'display_name' => 'Babahoyo',
            'province_id' => 13
        ]);
        City::factory()->create([
            'name' => 'portoviejo',
            'display_name' => 'Portoviejo',
            'province_id' => 14
        ]);
        City::factory()->create([
            'name' => 'macas',
            'display_name' => 'Macas',
            'province_id' => 15
        ]);
        City::factory()->create([
            'name' => 'tena',
            'display_name' => 'Tena',
            'province_id' => 16
        ]);
        City::factory()->create([
            'name' => 'puerto_francisco_de_orellana',
            'display_name' => 'Puerto Francisco de Orellana',
            'province_id' => 17
        ]);
        City::factory()->create([
            'name' => 'puyo',
            'display_name' => 'Puyo',
            'province_id' => 18
        ]);
        City::factory()->create([
            'name' => 'quito',
            'display_name' => 'Quito',
            'province_id' => 19
        ]);
        City::factory()->create([
            'name' => 'santa_elena',
            'display_name' => 'Santa Elena',
            'province_id' => 20
        ]);
        City::factory()->create([
            'name' => 'santo_domingo',
            'display_name' => 'Santo Domingo de los Colorados',
            'province_id' => 21
        ]);
        City::factory()->create([
            'name' => 'nueva_loja',
            'display_name' => '	Nueva Loja',
            'province_id' => 22
        ]);
        City::factory()->create([
            'name' => 'ambato',
            'display_name' => 'Ambato',
            'province_id' => 23
        ]);
        City::factory()->create([
            'name' => 'zamora',
            'display_name' => 'Zamora',
            'province_id' => 24
        ]);
    }
}
