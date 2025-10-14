<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\PlantCalculation;
use App\Models\GardenPlan;
use Illuminate\Support\Facades\Auth;

class MonthlyReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentMonth = Carbon::now();

        $reportData = $this->getReportData($user, $currentMonth);
        $theme = $user->theme ?? 'light';

        return view('monthly-report.index', compact('reportData', 'theme'));
    }

    public function generate(Request $request)
    {
        // Validate the request
        $request->validate([
            'month' => 'required|date_format:Y-m',
            'include_charts' => 'boolean'
        ]);

        $user = Auth::user();
        $selectedMonth = Carbon::createFromFormat('Y-m', $request->month);

        $reportData = $this->getReportData($user, $selectedMonth);
        $reportData['include_charts'] = $request->boolean('include_charts');
        $theme = $user->theme ?? 'light';

        if ($request->has('download')) {
            return $this->downloadPdf($reportData);
        }

        return view('monthly-report.index', compact('reportData', 'theme'));
    }

    public function downloadPdf($reportData)
    {
        // Implement PDF download functionality
        // You can use packages like barryvdh/laravel-dompdf
        
        return response()->json([
            'message' => 'PDF download functionality would be implemented here',
            'data' => $reportData
        ]);
    }

    public function apiData($month = null)
    {
        $user = Auth::user();
        $targetMonth = $month ? Carbon::createFromFormat('Y-m', $month) : Carbon::now();

        $calculations = PlantCalculation::where('user_id', $user->id)
            ->whereYear('created_at', $targetMonth->year)
            ->whereMonth('created_at', $targetMonth->month)
            ->get();

        // Return JSON data for AJAX requests or API
        return response()->json([
            'month' => $targetMonth->format('F Y'),
            'metrics' => [
                'total_area' => number_format($calculations->sum('total_area'), 2) . ' m²',
                'plants_calculated' => $calculations->sum('total_plants'),
                'total_calculations' => $calculations->count()
            ]
        ]);
    }

    private function getReportData($user, $month)
    {
        // Get calculations for the specified month
        $calculations = PlantCalculation::where('user_id', $user->id)
            ->whereYear('created_at', $month->year)
            ->whereMonth('created_at', $month->month)
            ->get();

        // Get garden plans for the specified month
        $gardenPlans = GardenPlan::where('user_id', $user->id)
            ->whereYear('created_at', $month->year)
            ->whereMonth('created_at', $month->month)
            ->get();

        // Calculate metrics
        $totalAreaPlanned = $calculations->sum('total_area');
        $plantsCalculated = $calculations->sum('total_plants');
        $plantTypesUsed = $calculations->whereNotNull('plant_type')->unique('plant_type')->count();
        $totalCalculations = $calculations->count();

        // Calculation types breakdown
        $squareCalculations = $calculations->where('calculation_type', 'square')->count();
        $quincunxCalculations = $calculations->where('calculation_type', 'quincunx')->count();
        $triangularCalculations = $calculations->where('calculation_type', 'triangular')->count();

        // Recent calculations
        $recentCalculations = $calculations->sortByDesc('created_at')->take(5)->map(function ($calc) {
            return [
                'date' => $calc->created_at->format('Y-m-d'),
                'type' => ucfirst($calc->calculation_type) . ' Planting',
                'area' => number_format($calc->total_area, 2) . ' m²'
            ];
        })->values()->all();

        // Most used tool
        $toolCounts = [
            'square' => $squareCalculations,
            'quincunx' => $quincunxCalculations,
            'triangular' => $triangularCalculations
        ];
        $mostUsedTool = array_keys($toolCounts, max($toolCounts))[0];
        $mostUsedTool = $mostUsedTool ? ucfirst($mostUsedTool) . ' Planting' : 'None';

        // Popular plants
        $popularPlants = $calculations->whereNotNull('plant_type')
            ->groupBy('plant_type')
            ->map(function ($group, $plantType) {
                return [
                    'name' => $plantType,
                    'calculations' => $group->count()
                ];
            })
            ->sortByDesc('calculations')
            ->take(5)
            ->values()
            ->all();

        return [
            'month' => $month->format('F Y'),
            'user' => $user->name,
            'status' => 'Online',
            'total_area_planned' => number_format($totalAreaPlanned, 2) . ' m²',
            'plants_calculated' => $plantsCalculated,
            'plant_types_used' => $plantTypesUsed,
            'total_calculations' => $totalCalculations,
            'square_planting_calculations' => $squareCalculations,
            'quincunx_planting_calculations' => $quincunxCalculations,
            'triangular_planting_calculations' => $triangularCalculations,
            'recent_calculations' => $recentCalculations,
            'reports_generated' => 1, // Placeholder - could track actual report generations
            'garden_plans_created' => $gardenPlans->count(),
            'most_used_tool' => $mostUsedTool,
            'popular_plants' => $popularPlants,
            'total_downloads' => 0, // Placeholder - could track actual downloads
            'tips' => [
                'Consider plant mature size when calculating spacing to ensure proper growth.',
                'Rotate crops seasonally to maintain soil health.',
                'Use companion planting to naturally repel pests.'
            ]
        ];
    }
}