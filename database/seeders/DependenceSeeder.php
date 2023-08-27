<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Subcircuit;

class DependenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //$user = User::find(1);
        //$vechile = Vehicle::find(1);
        $dependence = Subcircuit::find(1);

        $users = User::where('id','<','8')->get();
        $vehicles = Vehicle::where('id','<','8')->get();

        foreach($users as $key => $user){
            $user->subcircuits()->sync([$dependence->id]);
            $vehicles[$key]->subcircuits()->sync([$dependence->id]);
            $vehicles[$key]->users()->sync([$user->id]);
        }

        
    }
}
