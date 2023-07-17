<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CatalogItem;

class CatalogItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CatalogItem::create([
            'name'  => 'suggestion_item',
            'value' => 'Sugerencia'
        ]);

        CatalogItem::create([
            'name'  => 'suggestion_item',
            'value' => 'Reclamo'
        ]);

    }   
}
