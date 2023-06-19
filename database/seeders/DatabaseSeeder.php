<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BloodTypeSeeder::class,
            RankSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            ParishSeeder::class,
            CircuitSeeder::class,
            SubcircuitSeeder::class,
            UserSeeder::class,
            VehicleTypeSeeder::class
        ]);
    }
}
