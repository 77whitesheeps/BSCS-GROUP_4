<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantCalculation;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class QuincunxCalculatorController extends Controller
{
    /**
     * Display the initial calculator form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
       return view('quincunx-calculator', [
            'results' => null,
            'inputs'  => [
                'plantType'    => '',
                'areaLength'   => '',
                'areaWidth'    => '',
                'plantSpacing' => '',
                'borderSpacing'=> '0',
                'lengthUnit'   => 'm',
                'widthUnit'    => 'm',
                'spacingUnit'  => 'm',
                'borderUnit'   => 'm',
            ],
        ]);
    }

    /**
     * Calculate the quincunx planting details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calculate(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'plantType' => 'required|string|max:100',
            'areaLength' => 'required|numeric|min:0.01',
            'areaWidth' => 'required|numeric|min:0.01',
            'plantSpacing' => 'required|numeric|min:0.01',
            'rowSpacing' => 'required|numeric|min:0.01',
            'borderSpacing' => 'required|numeric|min:0',
            'lengthUnit' => 'required|in:m,ft,cm,in',
            'widthUnit' => 'required|in:m,ft,cm,in',
            'spacingUnit' => 'required|in:m,ft,cm,in',
            'rowSpacingUnit' => 'required|in:m,ft,cm,in',
            'borderUnit' => 'required|in:m,ft,cm,in',
        ], [
            'areaLength.required' => 'Area length is required.',
            'areaLength.min' => 'Area length must be greater than 0.',
            'plantSpacing.min' => 'Plant spacing must be greater than 0.',
            'rowSpacing.min' => 'Row spacing must be greater than 0.',
            'borderSpacing.required' => 'Border spacing is required.',
            'spacingUnit.required' => 'Spacing unit is required.',
            'rowSpacingUnit.required' => 'Row spacing unit is required.',
        ]);

        try {
            \Log::info('Quincunx calculation started for user: ' . auth()->id());

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
            $rowSpacingM = $validated['rowSpacing'] * $conversionRates[$validated['rowSpacingUnit']];
            $borderSpacingM = $validated['borderSpacing'] * $conversionRates[$validated['borderUnit']];

            // Calculate the recommended minimum border spacing (half of max spacing)
            $recommendedBorderSpacingM = max($plantSpacingM, $rowSpacingM) / 2;

            // Use the greater of the user's border input or the recommended value
            $effectiveBorderSpacingM = max($borderSpacingM, $recommendedBorderSpacingM);

            // Calculate effective planting area using the effective border spacing
            $effectiveLength = max(0, $lengthM - 2 * $effectiveBorderSpacingM);
            $effectiveWidth = max(0, $widthM - 2 * $effectiveBorderSpacingM);

            // Validation for effective area
            if ($effectiveLength <= 0 || $effectiveWidth <= 0) {
                return back()->withErrors([
                    'border_spacing' => 'Border spacing is too large for the given area dimensions. A minimum of ' . round($recommendedBorderSpacingM, 2) . ' m is recommended.'
                ])->withInput();
            }

            if ($plantSpacingM >= $effectiveLength || $plantSpacingM >= $effectiveWidth) {
                return back()->withErrors([
                    'plant_spacing' => 'Plant spacing is too large for the effective planting area.'
                ])->withInput();
            }

            // Calculate quincunx pattern properly
            $results = $this->calculateQuincunxPattern($effectiveLength, $effectiveWidth, $plantSpacingM, $rowSpacingM);
            
            // Add area information
            $results['effectiveArea'] = round($effectiveLength * $effectiveWidth, 2);
            $results['totalArea'] = round($lengthM * $widthM, 2);
            $results['plantingDensity'] = $results['totalPlants'] > 0 
                ? round($results['totalPlants'] / $results['effectiveArea'], 2) 
                : 0;

            // Add recommended border to results
            $results['recommendedBorderSpacingM'] = round($recommendedBorderSpacingM, 2);

            // Update user totals after calculation
            $user = Auth::user();
            $user->total_calculations += 1;
            $user->total_plants_calculated += $results['totalPlants'];
            $user->total_area_planned += $results['totalArea'];
            $user->save();

            // Save calculation to database
            \Log::info('Attempting to save quincunx calculation for user: ' . auth()->id());
            try {
                $calculation = PlantCalculation::create([
                    'user_id' => auth()->id(),
                    'calculation_name' => 'Quincunx Pattern - ' . now()->format('M j, Y g:i A'),
                    'calculation_type' => 'quincunx',
                    'plant_type' => $validated['plantType'],
                    'area_length' => $lengthM,
                    'area_width' => $widthM,
                    'plant_spacing' => $plantSpacingM,
                    'row_spacing' => $rowSpacingM,
                    'border_spacing' => $effectiveBorderSpacingM,
                    'total_plants' => $results['totalPlants'],
                    'plants_per_row' => $results['plantsPerRow'] ?? 0,
                    'number_of_rows' => $results['numberOfRows'] ?? 0,
                    'effective_area' => $results['effectiveArea'],
                    'planting_density' => $results['plantingDensity'],
                    'space_utilization' => $results['efficiency'] ?? 0,
                    'input_units' => json_encode([
                        'length_unit' => $validated['lengthUnit'],
                        'width_unit' => $validated['widthUnit'],
                        'spacing_unit' => $validated['spacingUnit'],
                        'row_spacing_unit' => $validated['rowSpacingUnit'],
                        'border_unit' => $validated['borderUnit']
                    ]),
                    'total_area' => $results['totalArea'],
                    'is_saved' => false,
                ]);
                \Log::info('Quincunx calculation saved successfully with ID: ' . $calculation->id);
            } catch (\Exception $saveError) {
                // Log the error but don't break the calculation
                \Log::error('Failed to save quincunx calculation: ' . $saveError->getMessage());
            }

            return view('quincunx-calculator', [
                'results' => $results,
                'inputs' => $validated
            ]);

        } catch (\Exception $e) {
            return back()->withErrors([
                'calculation' => 'An error occurred during calculation. Please check your inputs.'
            ])->withInput();
        }
    }

    /**
     * Calculate plants in quincunx (staggered) pattern
     *
     * @param  float  $length
     * @param  float  $width
     * @param  float  $plantSpacing
     * @param  float  $rowSpacing
     * @return array
     */
    private function calculateQuincunxPattern($length, $width, $plantSpacing, $rowSpacing)
    {
        // Calculate number of rows that fit
        $numberOfRows = floor($width / $rowSpacing) + 1;

        // Horizontal offset for alternating rows
        $horizontalOffset = $plantSpacing / 2;

        $totalPlants = 0;
        $rowDetails = [];

        for ($row = 0; $row < $numberOfRows; $row++) {
            $isOffsetRow = $row % 2 == 1;

            // Calculate available length for this row
            $availableLength = $isOffsetRow ? $length - $horizontalOffset : $length;

            // Skip if not enough space for even one plant
            if ($availableLength < 0) {
                continue;
            }

            // Plants in this row
            $plantsInRow = floor($availableLength / $plantSpacing) + 1;

            // Ensure at least one plant if there's any space
            $plantsInRow = max(0, $plantsInRow);

            $totalPlants += $plantsInRow;
            $rowDetails[] = [
                'row' => $row + 1,
                'plants' => $plantsInRow,
                'offset' => $isOffsetRow
            ];
        }

        // Calculate theoretical vs actual efficiency
        $theoreticalDensity = 2 / (sqrt(3) * pow($plantSpacing, 2)); // Plants per square meter in perfect quincunx
        $actualDensity = $totalPlants / ($length * $width);
        $efficiency = ($actualDensity / $theoreticalDensity) * 100;

        return [
            'totalPlants' => (int) $totalPlants,
            'numberOfRows' => (int) $numberOfRows,
            'plantsPerRow' => $numberOfRows > 0 ? round($totalPlants / $numberOfRows, 1) : 0,
            'rowSpacing' => round($rowSpacing, 3),
            'efficiency' => round($efficiency, 1),
            'averagePlantsPerRow' => $numberOfRows > 0 ? round($totalPlants / $numberOfRows, 1) : 0,
            'rowDetails' => $rowDetails, // Useful for visualization
            'patternType' => 'Quincunx (Staggered)',
        ];
    }

    /**
     * Get conversion rate to specified unit from meters
     *
     * @param  float  $value
     * @param  string  $unit
     * @return float
     */
    private function convertFromMeters($value, $unit)
    {
        $conversionRates = [
            'm' => 1,
            'ft' => 3.28084,
            'cm' => 100,
            'in' => 39.3701
        ];

        return round($value * $conversionRates[$unit], 2);
    }
}
