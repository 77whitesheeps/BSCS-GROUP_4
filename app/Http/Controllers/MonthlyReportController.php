<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class MonthlyReportController extends Controller
{
    public function index()
    {
        // Get current month and year
        $currentMonth = Carbon::now()->format('F Y');
        
        // Sample data - replace with your actual database queries
        $reportData = [
            'month' => $currentMonth,
            'user' => 'Dennis L. Sallyy Jr.',
            'status' => 'Online',
            'total_area_planned' => '0.00 m²',
            'plants_calculated' => 0,
            'plant_types_used' => 0,
            'total_calculations' => 0,
            'square_planting_calculations' => 0,
            'quincunx_planting_calculations' => 0,
            'triangular_planting_calculations' => 0,
            'recent_calculations' => [],
            'reports_generated' => 0,
            'garden_plans_created' => 0,
            'most_used_tool' => 'None',
            'popular_plants' => [],
            'total_downloads' => 0,
            'tips' => [
                'Consider plant mature size when calculating spacing to ensure proper growth.'
            ]
        ];

        return view('monthly-report.index', compact('reportData'));
    }

    public function generate(Request $request)
    {
        // Validate the request
        $request->validate([
            'month' => 'required|date_format:Y-m',
            'include_charts' => 'boolean'
        ]);

        // Get the specific month data
        $selectedMonth = Carbon::createFromFormat('Y-m', $request->month);
        
        // Here you would typically query your database for the selected month
        // For now, using sample data
        $reportData = [
            'month' => $selectedMonth->format('F Y'),
            'user' => 'Dennis L. Sallyy Jr.',
            'status' => 'Online',
            'total_area_planned' => '150.75 m²',
            'plants_calculated' => 45,
            'plant_types_used' => 12,
            'total_calculations' => 28,
            'square_planting_calculations' => 15,
            'quincunx_planting_calculations' => 8,
            'triangular_planting_calculations' => 5,
            'recent_calculations' => [
                ['date' => '2024-09-28', 'type' => 'Square Planting', 'area' => '25 m²'],
                ['date' => '2024-09-25', 'type' => 'Triangular Planting', 'area' => '18.5 m²'],
                ['date' => '2024-09-20', 'type' => 'Quincunx Planting', 'area' => '32.25 m²']
            ],
            'reports_generated' => 3,
            'garden_plans_created' => 2,
            'most_used_tool' => 'Square Planting',
            'popular_plants' => [
                ['name' => 'Tomato', 'calculations' => 8],
                ['name' => 'Lettuce', 'calculations' => 6],
                ['name' => 'Carrot', 'calculations' => 5]
            ],
            'total_downloads' => 5,
            'tips' => [
                'Consider plant mature size when calculating spacing to ensure proper growth.',
                'Rotate crops seasonally to maintain soil health.',
                'Use companion planting to naturally repel pests.'
            ],
            'include_charts' => $request->boolean('include_charts')
        ];

        if ($request->has('download')) {
            return $this->downloadPdf($reportData);
        }

        return view('monthly-report.index', compact('reportData'));
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
        $targetMonth = $month ? Carbon::createFromFormat('Y-m', $month) : Carbon::now();
        
        // Return JSON data for AJAX requests or API
        return response()->json([
            'month' => $targetMonth->format('F Y'),
            'metrics' => [
                'total_area' => '150.75 m²',
                'plants_calculated' => 45,
                'total_calculations' => 28
            ]
        ]);
    }
}