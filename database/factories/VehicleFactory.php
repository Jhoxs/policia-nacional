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
            'plate'              => strtoupper(fake()->bothify('???-####')),
            'chassis'            => strtoupper(fake()->bothify('??####???')),
            'brand'              => strtoupper(fake()->randomElement(['mazda','chevrolet','kia','toyota','bmw','audi','ford','fiat','hyundai'])),
            'model'              => strtoupper(fake()->randomElement(['bentayga','continental GT','flying spur','serie 1'])),
            'motor'              => strtoupper(fake()->randomElement(['alternativo','wankel','encendido por compresión','monocilindrico','vertical'])),
            'mileage'            => fake()->numerify('###'),
            'cylinder_capacity'  => fake()->numerify('##'),
            'loading_capacity'   => fake()->numerify('##'),
            'passenger_capacity' => fake()->numerify('#'),
            'vehicle_type_id'    => fake()->randomElement($vehicle_type),
        ];
    }
}
