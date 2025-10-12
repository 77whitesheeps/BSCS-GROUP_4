<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PlantCalculation;
use App\Models\GardenPlan;

class PopulateUserTotalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $calculations = $user->plantCalculations;
            $plans = $user->gardenPlans;

            $user->total_calculations = $calculations->count();
            $user->total_plant_types = $calculations->whereNotNull('plant_type')->unique('plant_type')->count();
            $user->total_plants_calculated = $calculations->sum('total_plants');
            $user->total_area_planned = $calculations->sum('total_area');
            $user->total_plans = $plans->count();
            $user->total_garden_area_planned = $plans->sum('total_area');

            $user->save();
        }
    }
}
