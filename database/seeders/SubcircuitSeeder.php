<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcircuit;

class SubcircuitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subcircuit::factory()->create([
            'code' => '11D01C01S01',
            'name' => 'vilcabamba_1',
            'display_name' => 'Vilcabamba 1',
            'circuit_id' => 1
        ]);
        Subcircuit::factory()->create([
            'code' => '11D01C02S01',
            'name' => 'yanagana_1',
            'display_name' => 'Yanagana 1',
            'circuit_id' => 2
        ]);
        Subcircuit::factory()->create([
            'code' => '11D01C03S01',
            'name' => 'malacatos_1',
            'display_name' => 'Malacatos 1',
            'circuit_id' => 3
        ]);
        Subcircuit::factory()->create([
            'code' => '11D01C04S01',
            'name' => 'taquil_1',
            'display_name' => 'Taquil 1',
            'circuit_id' => 4
        ]);
        Subcircuit::factory()->create([
            'code' => '11D01C04S02',
            'name' => 'taquil_2',
            'display_name' => 'Taquil 2',
            'circuit_id' => 4
        ]);
        Subcircuit::factory()->create([
            'code' => '11D01C05S01',
            'name' => 'zamora_huayco_1',
            'display_name' => 'Zamora Huayco 1',
            'circuit_id' => 5
        ]);
        Subcircuit::factory()->create([
            'code' => '11D01C06S01',
            'name' => 'esteban_godoy_1',
            'display_name' => 'Esteban Godoy 1',
            'circuit_id' => 6
        ]);
        Subcircuit::factory()->create([
            'code' => '11D01C06S02',
            'name' => 'esteban_godoy_2',
            'display_name' => 'Esteban Godoy 2',
            'circuit_id' => 6
        ]);
        Subcircuit::factory()->create([
            'code' => '11D01C07S01',
            'name' => 'el_paraiso_1',
            'display_name' => 'El Paraiso 1',
            'circuit_id' => 7
        ]);
        Subcircuit::factory()->create([
            'code' => '11D01C08S01',
            'name' => 'celi_roman_1',
            'display_name' => 'Celi Roman 1',
            'circuit_id' => 8
        ]);
        Subcircuit::factory()->create([
            'code' => '11D01C09S01',
            'name' => 'los_molinos',
            'display_name' => 'IV Centenario 1',
            'circuit_id' => 9
        ]);
        Subcircuit::factory()->create([
            'code' => '11D01C10S01',
            'name' => 'tebaida_1',
            'display_name' => 'Tebaida 1',
            'circuit_id' => 10
        ]);
        Subcircuit::factory()->create([
            'code' => '11D01C11S01',
            'name' => 'los_molinos_1',
            'display_name' => 'Los Molinos 1',
            'circuit_id' => 11
        ]);
        Subcircuit::factory()->create([
            'code' => '11D01C12S01',
            'name' => 'chontacruz_1',
            'display_name' => 'Chontacruz 1',
            'circuit_id' => 12
        ]);
        Subcircuit::factory()->create([
            'code' => '11D02C01S01',
            'name' => 'el_tambo_1',
            'display_name' => 'El Tambo 1',
            'circuit_id' => 13
        ]);
        Subcircuit::factory()->create([
            'code' => '11D02C02S02',
            'name' => 'catamayo_norte_1',
            'display_name' => 'Catamayo Norte 1',
            'circuit_id' => 14
        ]);
        Subcircuit::factory()->create([
            'code' => '11D02C05',
            'name' => 'catamayo_norte_2',
            'display_name' => 'Catamayo Norte 2',
            'circuit_id' => 14
        ]);
        Subcircuit::factory()->create([
            'code' => '11D02C03S01',
            'name' => 'catamayo_san_jose_1',
            'display_name' => 'Catamayo San José 1',
            'circuit_id' => 15
        ]);
        Subcircuit::factory()->create([
            'code' => '11D02C04S01',
            'name' => 'guayquichuma_1',
            'display_name' => 'Guayquichuma 1',
            'circuit_id' => 16
        ]);
        Subcircuit::factory()->create([
            'code' => '11D02C05S01',
            'name' => 'san_pedro_de_la_bendita_1',
            'display_name' => 'San Pedro de la Bendita 1',
            'circuit_id' => 17
        ]);
        Subcircuit::factory()->create([
            'code' => '11D02C06S01',
            'name' => 'chaguarpamba_1',
            'display_name' => 'Chaguarpamba 1',
            'circuit_id' => 18
        ]);
    }
}
