<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\VehicleType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vehicle_type = VehicleType::pluck('id')->all();
        return [
            'plate' => fake()->unique()->name(),
            'chassis' => fake()->name(),
            'brand' => fake()->name(),
            'model' => fake()->name(),
            'motor' => fake()->name(),
            'mileage' => fake()->numerify('###'),
            'cylinder_capacity' => fake()->numerify('##'),
            'loading_capacity' => fake()->numerify('##'),
            'passenger_capacity' => fake()->numerify('#'),
            'vehicle_type_id' => fake()->randomElement($vehicle_type),
        ];
    }
}
