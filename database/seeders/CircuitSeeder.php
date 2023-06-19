<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Circuit;

class CircuitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Circuit::factory()->create([
            'code' => '11D01C01',
            'name' => 'vilcabamba',
            'display_name' => 'Vilcabamba',
            'parish_id' => 6
        ]);
        Circuit::factory()->create([
            'code' => '11D01C02',
            'name' => 'yanagana',
            'display_name' => 'Yanagana',
            'parish_id' => 6
        ]);
        Circuit::factory()->create([
            'code' => '11D01C03',
            'name' => 'malacatos',
            'display_name' => 'Malacatos',
            'parish_id' => 6
        ]);
        Circuit::factory()->create([
            'code' => '11D01C04',
            'name' => 'taquil',
            'display_name' => 'Taquil',
            'parish_id' => 6
        ]);
        Circuit::factory()->create([
            'code' => '11D01C05',
            'name' => 'zamorahuayco',
            'display_name' => 'Zamorahuayco',
            'parish_id' => 6
        ]);
        Circuit::factory()->create([
            'code' => '11D01C06',
            'name' => 'estebangodoy',
            'display_name' => 'Estebangodoy',
            'parish_id' => 6
        ]);
        Circuit::factory()->create([
            'code' => '11D01C07',
            'name' => 'el_paraiso',
            'display_name' => 'El Paraiso',
            'parish_id' => 6
        ]);
        Circuit::factory()->create([
            'code' => '11D01C08',
            'name' => 'celi_roman',
            'display_name' => 'Celi Roman',
            'parish_id' => 6
        ]);
        Circuit::factory()->create([
            'code' => '11D01C09',
            'name' => 'iv_centena_rio',
            'display_name' => 'IV Centena Río',
            'parish_id' => 6
        ]);
        Circuit::factory()->create([
            'code' => '11D01C10',
            'name' => 'tebaida',
            'display_name' => 'Tebaida',
            'parish_id' => 6
        ]);
        Circuit::factory()->create([
            'code' => '11D01C11',
            'name' => 'los_molinos',
            'display_name' => 'Los Molinos',
            'parish_id' => 6
        ]);
        Circuit::factory()->create([
            'code' => '11D01C12',
            'name' => 'chontac_ruz',
            'display_name' => 'Chontac Ruz',
            'parish_id' => 6
        ]);
        Circuit::factory()->create([
            'code' => '11D02C01',
            'name' => 'el_tambo',
            'display_name' => 'El Tambo',
            'parish_id' => 8
        ]);
        Circuit::factory()->create([
            'code' => '11D02C02',
            'name' => 'catamayo_norte',
            'display_name' => 'Catamayo Norte',
            'parish_id' => 8
        ]);
        Circuit::factory()->create([
            'code' => '11D02C03',
            'name' => 'catamayo_san_jose',
            'display_name' => 'Catamayo San Jose',
            'parish_id' => 8
        ]);
        Circuit::factory()->create([
            'code' => '11D02C04',
            'name' => 'guayquichuma',
            'display_name' => 'Guayquichuma',
            'parish_id' => 8
        ]);
        Circuit::factory()->create([
            'code' => '11D02C05',
            'name' => 'san_pedro_de_la_bendita',
            'display_name' => 'San Pedro de la Bendita',
            'parish_id' => 8
        ]);
        Circuit::factory()->create([
            'code' => '11D02C06',
            'name' => 'chaguarpamba',
            'display_name' => 'Chaguarpamba',
            'parish_id' => 8
        ]);
    }
}
