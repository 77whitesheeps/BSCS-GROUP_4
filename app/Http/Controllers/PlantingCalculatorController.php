<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantCalculation; // Import the PlantCalculation model
use Illuminate\Support\Facades\Auth; // Import Auth facade

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
            'plantType' => 'required|string|max:100',
            'areaLength' => 'required|numeric|min:0.01',
            'areaWidth' => 'required|numeric|min:0.01',
            'plantSpacing' => 'required|numeric|min:0.01',
            'rowSpacing' => 'required|numeric|min:0.01',
            'borderSpacing' => 'required|numeric|min:0',
            'lengthUnit' => 'required|string|in:m,ft,cm,in',
            'widthUnit' => 'required|string|in:m,ft,cm,in',
            'borderUnit' => 'required|string|in:m,ft,cm,in',
            'autoBorder' => 'nullable|boolean',
        ]);

        // Extract values
        $areaLength = $validated['areaLength'];
        $areaWidth = $validated['areaWidth'];
        $plantSpacing = $validated['plantSpacing'];
        $rowSpacing = $validated['rowSpacing'];
        $borderSpacing = $validated['borderSpacing'];

        // Check if border spacing is too large
        if ($borderSpacing * 2 >= $areaLength || $borderSpacing * 2 >= $areaWidth) {
            return back()->withErrors([
                'borderSpacing' => 'Border spacing is too large. It must be less than half of the area length and width.'
            ])->withInput();
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

        // Save calculation to database
        try {
            $calculationData = [
                'user_id' => auth()->id(),
                'plant_type' => $validated['plantType'],
                'calculation_name' => 'Square Pattern - ' . now()->format('M j, Y g:i A'),
                'calculation_type' => 'square',
                'area_length' => $areaLength,
                'area_width' => $areaWidth,
                'area_length_unit' => 'm',
                'area_width_unit' => 'm',
                'plant_spacing' => $plantSpacing,
                'plant_spacing_unit' => 'm',
                // Note: row_spacing is not saved as it's the same as plant_spacing for square pattern
                'total_plants' => $totalPlants,
                'rows' => $numberOfRows,
                'columns' => $plantsPerRow,
                'effective_length' => $effectiveLength,
                'effective_width' => $effectiveWidth,
                'total_area' => round($areaLength * $areaWidth, 2),
                'border_spacing' => $borderSpacing,
                'is_saved' => false,
            ];
            
            // Log the data being saved for debugging
            logger()->info('Saving Square calculation data:', $calculationData);
            
            $calculation = PlantCalculation::create($calculationData);
            
            logger()->info('Square calculation saved successfully with ID: ' . $calculation->id);
            
        } catch (\Exception $saveError) {
            // Log the error with more details
            logger()->error('Failed to save Square calculation: ' . $saveError->getMessage(), [
                'error' => $saveError->getMessage(),
                'trace' => $saveError->getTraceAsString(),
                'data' => $calculationData ?? []
            ]);
        }

        // Prepare results array for the view
        $results = [
            'totalPlants' => $totalPlants,
            'plantsPerRow' => $plantsPerRow,
            'numberOfRows' => $numberOfRows,
            'effectiveArea' => round($effectiveArea, 2),
            'plantingDensity' => round($plantingDensity, 2),
            'spaceUtilization' => round($spaceUtilization, 1),
            'effectiveLength' => round($effectiveLength, 2),
            'effectiveWidth' => round($effectiveWidth, 2),
            'areaLength' => $areaLength,
            'areaWidth' => $areaWidth,
            'plantSpacing' => $plantSpacing,
            'rowSpacing' => $rowSpacing,
            'borderSpacing' => $borderSpacing
        ];

        return view('planting-calculator', [
            'results' => $results,
            'inputs' => $validated,
            'success' => 'Calculation completed successfully! Results saved to history.'
        ]);
    }
}