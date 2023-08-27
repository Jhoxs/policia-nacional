<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Spare;

class SpareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //1
        Spare::updateOrCreate([
            'name'      => 'Aceite',
            'brand'     => 'Genérica',
            'detail'    => 'Descripción Genérica',
            'price'     => 20
        ]);

        //2
        Spare::updateOrCreate([
            'name'      => 'Pastillas',
            'brand'     => 'Genérica',
            'detail'    => 'Descripción Genérica',
            'price'     => 10
        ]);

        //3
        Spare::updateOrCreate([
            'name'      => 'Liquido de Frenos',
            'brand'     => 'Genérica',
            'detail'    => 'Descripción Genérica',
            'price'     => 10
        ]);

        //4
        Spare::updateOrCreate([
            'name'      => 'Filtro de Combustible',
            'brand'     => 'Genérica',
            'detail'    => 'Descripción Genérica',
            'price'     => 20
        ]);

        //5
        Spare::updateOrCreate([
            'name'      => 'Filtro de Aire',
            'brand'     => 'Genérica',
            'detail'    => 'Descripción Genérica',
            'price'     => 20
        ]);

        //6
        Spare::updateOrCreate([
            'name'      => 'Líquido Refrigerante',
            'brand'     => 'Genérica',
            'detail'    => 'Descripción Genérica',
            'price'     => 15
        ]);

        //7
        Spare::updateOrCreate([
            'name'      => 'Luces Delanteras',
            'brand'     => 'Genérica',
            'detail'    => 'Descripción Genérica',
            'price'     => 8.50
        ]);

        //8
        Spare::updateOrCreate([
            'name'      => 'Luces Posteriores',
            'brand'     => 'Genérica',
            'detail'    => 'Descripción Genérica',
            'price'     => 7.50
        ]);

        //9
        Spare::updateOrCreate([
            'name'      => 'Batería',
            'brand'     => 'Genérica',
            'detail'    => 'Descripción Genérica',
            'price'     => 20
        ]);

        //10
        Spare::updateOrCreate([
            'name'      => 'Sistema Eléctrico',
            'brand'     => 'Genérica',
            'detail'    => 'Descripción Genérica',
            'price'     => 50
        ]);
    }
}
