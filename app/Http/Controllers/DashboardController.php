<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantCalculation;
use App\Models\GardenPlan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get user's calculation statistics
        $userCalculations = PlantCalculation::where('user_id', $user->id);
        $userGardenPlans = GardenPlan::where('user_id', $user->id);

        $data = [
            'totalCalculations' => $user->total_calculations,
            'plantTypes' => $user->total_plant_types,
            'plantsCalculated' => $user->total_plants_calculated,
            'totalAreaPlanned' => $this->formatArea($user->total_area_planned),
            'totalPlans' => $user->total_plans,
            'totalGardenAreaPlanned' => $this->formatArea($user->total_garden_area_planned),
            'recentCalculations' => PlantCalculation::where('user_id', $user->id)
                                                   ->latest()
                                                   ->limit(5)
                                                   ->get(),
            'popularPlants' => PlantCalculation::where('user_id', $user->id)
                                              ->whereNotNull('plant_type')
                                              ->select('plant_type', DB::raw('count(*) as calculations_count'), DB::raw('sum(total_plants) as total_plants'))
                                              ->groupBy('plant_type')
                                              ->orderBy('calculations_count', 'desc')
                                              ->limit(5)
                                              ->get(),
        ];

        return view('dashboard', compact('data'));
    }

    private function formatArea($totalAreaSqMeters)
    {
        if ($totalAreaSqMeters >= 10000) {
            return number_format($totalAreaSqMeters / 10000, 2) . ' ha';
        } else {
            return number_format($totalAreaSqMeters, 2) . ' m²';
        }
    }
}
