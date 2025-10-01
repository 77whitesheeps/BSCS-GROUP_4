<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TriangularCalculatorController extends Controller
{
    public function index()
    {
        return view('triangular-calculator', [
            'results' => null,
            'inputs' => [
                'areaLength'   => '',
                'areaWidth'    => '',
                'plantSpacing' => '',
                'borderSpacing'=> '0',
                'lengthUnit'   => 'm',
                'widthUnit'    => 'm',
                'spacingUnit'  => 'm',
                'borderUnit'   => 'm',
            ]
        ]);
    }

    public function calculate(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'areaLength' => 'required|numeric|min:0.01',
            'areaWidth' => 'required|numeric|min:0.01',
            'plantSpacing' => 'required|numeric|min:0.01',
            'borderSpacing' => 'required|numeric|min:0',
            'lengthUnit' => 'required|in:m,ft,cm,in',
            'widthUnit' => 'required|in:m,ft,cm,in',
            'spacingUnit' => 'required|in:m,ft,cm,in',
            'borderUnit' => 'required|in:m,ft,cm,in',
        ]);

        try {
            // Convert all to meters for calculation
            $conversionRates = [
                'm' => 1,
                'ft' => 0.3048,
                'cm' => 0.01,
                'in' => 0.0254
            ];

            $lengthM = $validated['areaLength'] * $conversionRates[$validated['lengthUnit']];
            $widthM = $validated['areaWidth'] * $conversionRates[$validated['widthUnit']];
            $plantSpacingM = $validated['plantSpacing'] * $conversionRates[$validated['spacingUnit']];
            $borderSpacingM = $validated['borderSpacing'] * $conversionRates[$validated['borderUnit']];
            
            // Calculate the recommended minimum border spacing (half of plant spacing)
            $recommendedBorderSpacingM = $plantSpacingM / 2;

            // Use the greater of the user's border input or the recommended value
            $effectiveBorderSpacingM = max($borderSpacingM, $recommendedBorderSpacingM);

            // Calculate effective planting area using the effective border spacing
            $effectiveLength = max(0, $lengthM - 2 * $effectiveBorderSpacingM);
            $effectiveWidth = max(0, $widthM - 2 * $effectiveBorderSpacingM);

            if ($effectiveLength <= 0 || $effectiveWidth <= 0 || $plantSpacingM <= 0) {
                return back()->withErrors([
                    'border_spacing' => 'Invalid input values. Please check your measurements. A minimum border of ' . round($recommendedBorderSpacingM, 2) . ' m is recommended.'
                ])->withInput();
            }

            // Calculate number of plants using triangular pattern
            $plantsPerRow = floor($effectiveLength / $plantSpacingM) + 1;
            $numberOfRows = floor($effectiveWidth / ($plantSpacingM * 0.866)) + 1; // 0.866 = sqrt(3)/2
            $totalPlants = $plantsPerRow * $numberOfRows;

            // Calculate additional metrics
            $effectiveArea = $effectiveLength * $effectiveWidth;
            $plantingDensity = $totalPlants / $effectiveArea;
            
            // For triangular spacing, each plant occupies 0.866 * spacing^2 area
            $spaceUtilization = ($totalPlants * 0.866 * pow($plantSpacingM, 2)) / $effectiveArea * 100;

            // Prepare results
            $results = [
                'totalPlants' => $totalPlants,
                'plantsPerRow' => $plantsPerRow,
                'numberOfRows' => $numberOfRows,
                'effectiveArea' => $effectiveArea,
                'plantingDensity' => $plantingDensity,
                'spaceUtilization' => $spaceUtilization,
                'recommendedBorderSpacingM' => round($recommendedBorderSpacingM, 2)
            ];

            return view('triangular-calculator', [
                'results' => $results,
                'inputs' => $validated
            ]);
            
        } catch (\Exception $e) {
            return back()->withErrors('An error occurred during calculation. Please check your inputs.')->withInput();
        }
    }
}