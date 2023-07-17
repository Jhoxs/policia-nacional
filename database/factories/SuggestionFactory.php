<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subcircuit;
use App\Models\CatalogItem;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SuggestionFactory extends Factory
{        
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $subcircuitId = Subcircuit::pluck('id')->all();
        $catalogId = CatalogItem::where('name','suggestion_item')->pluck('id');
        return [
            'subcircuit_id'     => fake()->randomElement($subcircuitId),
            'catalog_item_id'   => fake()->randomElement($catalogId),
            'description'       => fake()->paragraph(),
            'name'              => fake()->name(),
            'last_name'         => fake()->name(),
        ];
    }
}
