<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contract;


class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //CONRATO 1
        $contract1 = Contract::updateOrCreate([
            'name'      => 'Contrato Mantenimiento 1',
            'detail'    => 'Descripción Contrato Mantenimiento No.1',
            'price'     => 60
        ]);

        $contract1->spares()->sync([1,2,3,4]);
        
        //CONRATO 2
        $contract2 = Contract::updateOrCreate([
            'name'      => 'Contrato Mantenimiento 2 Vehículos',
            'detail'    => 'Contrato Aplicado a Vehículos Con Filtro de Aire',
            'price'     => 111
        ]);

        $contract2->spares()->sync([1,2,3,4,5,6,7,8]);
        
        //CONRATO 3
        $contract3 = Contract::updateOrCreate([
            'name'      => 'Contrato Mantenimiento 2 Motos',
            'detail'    => 'Contrato Aplicado a Motos Sin Filtro de Aire',
            'price'     => 91
        ]);

        $contract3->spares()->sync([1,2,3,4,6,7,8]);
        
        //CONRATO 4
        $contract4 = Contract::updateOrCreate([
            'name'      => 'Contrato Mantenimiento 3',
            'detail'    => 'Descripción Contrato Mantenimiento No.3',
            'price'     => 70
        ]);

        $contract4->spares()->sync([9,10]);

        
    }
}
