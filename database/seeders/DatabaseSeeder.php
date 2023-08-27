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
            WorkingCalendarSeeder::class,
            CatalogItemSeeder::class,
            BloodTypeSeeder::class,
            RankSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            ParishSeeder::class,
            CircuitSeeder::class,
            SubcircuitSeeder::class,
            UserSeeder::class,
            VehicleTypeSeeder::class,
            RoleAndPermissionSeeder::class,
            VehicleSeeder::class,
            SuggestionSeeder::class,
            DependenceSeeder::class,
            SpareSeeder::class,
            ContractSeeder::class,
            MaintenanceTypeSeeder::class,
        ]);
    }
}
