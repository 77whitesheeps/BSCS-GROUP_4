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

        // Get real-time calculation statistics directly from database
        $userCalculations = PlantCalculation::where('user_id', $user->id);
        $userGardenPlans = GardenPlan::where('user_id', $user->id);

        // Calculate real-time totals
        $totalCalculations = $userCalculations->count();
        $plantTypes = $userCalculations->whereNotNull('plant_type')
                                      ->distinct('plant_type')
                                      ->count('plant_type');
        $plantsCalculated = $user->total_plants_calculated;
        $totalAreaPlanned = $user->total_area_planned;
        $totalPlans = $userGardenPlans->count();
        $totalGardenAreaPlanned = $userGardenPlans->sum('total_area') ?? 0;

        // Update user totals in background to keep them in sync
        $user->update([
            'total_calculations' => $totalCalculations,
            'total_plant_types' => $plantTypes,
            'total_plans' => $totalPlans,
            'total_garden_area_planned' => $totalGardenAreaPlanned,
        ]);

        $data = [
            'totalCalculations' => $totalCalculations,
            'plantTypes' => $plantTypes,
            'plantsCalculated' => $plantsCalculated,
            'totalAreaPlanned' => $this->formatArea($totalAreaPlanned),
            'totalPlans' => $totalPlans,
            'totalGardenAreaPlanned' => $this->formatArea($totalGardenAreaPlanned),
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
