<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Parish;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Circuit>
 */
class CircuitFactory extends Factory
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
            'parish_id' => Parish::factory()
        ];
    }
}
