<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MaintenanceType;

class MaintenanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //MANTENIMIENTO 1
        $maintenance1_array = [
            'list'          => [
                'Cambio de aceite',
                'Revisión',
                'Cambio de pastillas',
                'Líquido de frenos',
                'Cambio del filtro de combustible'
            ],
            'discard_list'  => [],
            'desciption'    => 'Descripción del Mantenimiento 1',
            'discard_price' => [],
            'discard_type'  => [] 
        ]; 

        $maintenance1 = MaintenanceType::updateOrCreate([
            'name'      => 'Mantenimiento 1',
            'price'     => 43.59,
            'detail'    => $maintenance1_array
        ]);

        //MANTENIMIENTO 2
        $maintenance2_array = [
            'list'          => [
                'Cambio de aceite',
                'Revisión',
                'Cambio de pastillas',
                'Líquido de frenos',
                'Cambio del filtro de combustible',
                'Cambio de filtro de aire',
                'Cambio de luces delanteras',
                'Cambio de luces posteiores'
            ],
            'discard_list'  => [
                'Cambio de filtro de aire'
            ],
            'desciption'    => 'Descripción del Mantenimiento 2',
            'discard_price' => [15],
            'discard_type'  => [
                'Motocicleta'
            ]
        ]; 

        $maintenance2 = MaintenanceType::updateOrCreate([
            'name'      => 'Mantenimiento 2',
            'price'     => 60,
            'detail'    => $maintenance2_array
        ]);

        //MANTENIMIENTO 3
        $maintenance3_array = [
            'list'          => [
                'Cambio de batería',
                'Ajustes en el sitema electrico',
            ],
            'discard_list'  => [],
            'desciption'    => 'Descripción del Mantenimiento 3',
            'discard_price' => [],
            'discard_type'  => []  
        ]; 

        $maintenance3 = MaintenanceType::updateOrCreate([
            'name'      => 'Mantenimiento 3',
            'price'     => 180,
            'detail'    => $maintenance3_array
        ]);
    }
}
