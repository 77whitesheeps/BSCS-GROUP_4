<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlantingCalculatorController extends Controller
{
    /**
     * Display the square planting calculator form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('planting-calculator');
    }

    /**
     * Process the calculation (if you want server-side processing too)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculate(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'areaLength' => 'required|numeric|min:0.01',
            'areaWidth' => 'required|numeric|min:0.01',
            'plantSpacing' => 'required|numeric|min:0.01',
            'rowSpacing' => 'required|numeric|min:0.01',
            'borderSpacing' => 'required|numeric|min:0',
        ]);

        // Extract values
        $areaLength = $validated['areaLength'];
        $areaWidth = $validated['areaWidth'];
        $plantSpacing = $validated['plantSpacing'];
        $rowSpacing = $validated['rowSpacing'];
        $borderSpacing = $validated['borderSpacing'];

        // Check if border spacing is too large
        if ($borderSpacing * 2 >= $areaLength || $borderSpacing * 2 >= $areaWidth) {
            return response()->json([
                'error' => 'Border spacing is too large. It must be less than half of the area length and width.'
            ], 422);
        }

        // Calculate planting layout
        $effectiveLength = $areaLength - 2 * $borderSpacing;
        $effectiveWidth = $areaWidth - 2 * $borderSpacing;

        // Calculate plants per row and number of rows with square pattern
        $plantsPerRow = floor($effectiveLength / $plantSpacing) + 1;
        $numberOfRows = floor($effectiveWidth / $rowSpacing) + 1;

        // Calculate total plants
        $totalPlants = $plantsPerRow * $numberOfRows;

        // Calculate other metrics
        $effectiveArea = $effectiveLength * $effectiveWidth;
        $plantingDensity = $totalPlants / $effectiveArea;
        $spaceUtilization = ($totalPlants * pi() * pow(min($plantSpacing, $rowSpacing)/4, 2)) / $effectiveArea * 100;

        return response()->json([
            'totalPlants' => $totalPlants,
            'plantsPerRow' => $plantsPerRow,
            'numberOfRows' => $numberOfRows,
            'effectiveArea' => round($effectiveArea, 2),
            'plantingDensity' => round($plantingDensity, 2),
            'spaceUtilization' => round($spaceUtilization, 1)
        ]);
    }
}