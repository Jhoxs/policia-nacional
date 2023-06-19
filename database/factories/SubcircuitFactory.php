<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Circuit;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subcircuit>
 */
class SubcircuitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->name(),
            'name' => fake()->unique()->name(),
            'display_name' => fake()->name(),
            'circuit_id' => Circuit::factory()
        ];
    }
}
