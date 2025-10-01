<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'plantSpacing.min' => 'Plant spacing must be greater than 0.',
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
            $results = $this->calculateQuincunxPattern($effectiveLength, $effectiveWidth, $plantSpacingM);
            
            // Add area information
            $results['effectiveArea'] = round($effectiveLength * $effectiveWidth, 2);
            $results['totalArea'] = round($lengthM * $widthM, 2);
            $results['plantingDensity'] = $results['totalPlants'] > 0 
                ? round($results['totalPlants'] / $results['effectiveArea'], 2) 
                : 0;

            // Add recommended border to results
            $results['recommendedBorderSpacingM'] = round($recommendedBorderSpacingM, 2);

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
     * @param  float  $spacing
     * @return array
     */
    private function calculateQuincunxPattern($length, $width, $spacing)
    {
        // Row spacing for quincunx pattern (triangular spacing)
        $rowSpacing = $spacing * sqrt(3) / 2;
        
        // Calculate number of rows that fit
        $numberOfRows = floor($width / $rowSpacing) + 1;
        
        // Horizontal offset for alternating rows
        $horizontalOffset = $spacing / 2;
        
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
            $plantsInRow = floor($availableLength / $spacing) + 1;
            
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
        $theoreticalDensity = 2 / (sqrt(3) * pow($spacing, 2)); // Plants per square meter in perfect quincunx
        $actualDensity = $totalPlants / ($length * $width);
        $efficiency = ($actualDensity / $theoreticalDensity) * 100;
        
        return [
            'totalPlants' => (int) $totalPlants,
            'numberOfRows' => (int) $numberOfRows,
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