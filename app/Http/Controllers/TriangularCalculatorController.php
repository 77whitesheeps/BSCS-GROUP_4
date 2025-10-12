<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantCalculation;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class TriangularCalculatorController extends Controller
{
    public function index()
    {
        return view('triangular-calculator', [
            'results' => null,
            'inputs' => [
                'plantType'    => '',
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
            'plantType' => 'required|string|max:100',
            'areaLength' => 'required|numeric|min:0.01',
            'areaWidth' => 'required|numeric|min:0.01',
            'plantSpacing' => 'required|numeric|min:0.01',
            'borderSpacing' => 'required|numeric|min:0',
            'lengthUnit' => 'required|in:m,ft,cm,in',
            'widthUnit' => 'required|in:m,ft,cm,in',
            'spacingUnit' => 'required|in:m,ft,cm,in',
            'borderUnit' => 'required|in:m,ft,cm,in',
        ], [
            'areaLength.required' => 'Area length is required.',
            'areaLength.min' => 'Area length must be greater than 0.',
            'areaWidth.required' => 'Area width is required.',
            'areaWidth.min' => 'Area width must be greater than 0.',
            'plantSpacing.min' => 'Plant spacing must be greater than 0.',
            'borderSpacing.required' => 'Border spacing is required.',
            'spacingUnit.required' => 'Spacing unit is required.',
        ]);

        try {
            \Log::info('Triangular calculation started for user: ' . auth()->id());

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

            // Update user totals after calculation
            $user = Auth::user();
            $user->total_calculations += 1;
            $user->total_plants_calculated += $totalPlants;
            $user->total_area_planned += round($lengthM * $widthM, 2);
            $user->save();

            // Save calculation to database
            \Log::info('Attempting to save triangular calculation for user: ' . auth()->id());
            try {
                $calculation = PlantCalculation::create([
                    'user_id' => auth()->id(),
                    'calculation_name' => 'Triangular Pattern - ' . now()->format('M j, Y g:i A'),
                    'calculation_type' => 'triangular',
                    'plant_type' => $validated['plantType'],
                    'area_length' => $lengthM,
                    'area_width' => $widthM,
                    'plant_spacing' => $plantSpacingM,
                    'row_spacing' => $plantSpacingM * 0.866, // Triangular row spacing
                    'border_spacing' => $effectiveBorderSpacingM,
                    'total_plants' => $totalPlants,
                    'plants_per_row' => $plantsPerRow,
                    'number_of_rows' => $numberOfRows,
                    'effective_area' => $effectiveArea,
                    'planting_density' => $plantingDensity,
                    'space_utilization' => $spaceUtilization,
                    'input_units' => json_encode([
                        'length_unit' => $validated['lengthUnit'],
                        'width_unit' => $validated['widthUnit'],
                        'spacing_unit' => $validated['spacingUnit'],
                        'border_unit' => $validated['borderUnit']
                    ]),
                    'total_area' => round($lengthM * $widthM, 2),
                    'is_saved' => false,
                ]);
                \Log::info('Triangular calculation saved successfully with ID: ' . $calculation->id);
            } catch (\Exception $saveError) {
                // Log the error but don't break the calculation
                \Log::error('Failed to save triangular calculation: ' . $saveError->getMessage());
            }

            return view('triangular-calculator', [
                'results' => $results,
                'inputs' => $validated
            ]);
            
        } catch (\Exception $e) {
            return back()->withErrors('An error occurred during calculation. Please check your inputs.')->withInput();
        }
    }
}