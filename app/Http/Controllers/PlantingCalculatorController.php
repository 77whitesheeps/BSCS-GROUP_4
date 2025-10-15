<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantCalculation; // Import the PlantCalculation model
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\DB;
use App\Notifications\GenericNotification;

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
     * Process the calculation (AJAX endpoint for saving calculations)
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

        /** @var \App\Models\User $user */
        $user = $request->user();

        // Extract values
        $areaLength = $validated['areaLength'];
        $areaWidth = $validated['areaWidth'];
        $plantSpacing = $validated['plantSpacing'];
        $rowSpacing = $validated['rowSpacing'];
        $borderSpacing = $validated['borderSpacing'];

        // Check if border spacing is too large
        if ($borderSpacing * 2 >= $areaLength || $borderSpacing * 2 >= $areaWidth) {
            return response()->json([
                'success' => false,
                'message' => 'Border spacing is too large. It must be less than half of the area length and width.'
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
        $plantingDensity = $totalPlants > 0 ? $totalPlants / $effectiveArea : 0;
        $spaceUtilization = $effectiveArea > 0 ? ($totalPlants * pi() * pow(min($plantSpacing, $rowSpacing)/4, 2)) / $effectiveArea * 100 : 0;

        // Save calculation to database
        try {
            $calculationData = [
                'user_id' => $user->id,
                'plant_type' => $validated['plantType'],
                'calculation_name' => 'Square Pattern - ' . now()->format('M j, Y g:i A'),
                'calculation_type' => 'square',
                'area_length' => $areaLength,
                'area_width' => $areaWidth,
                'plant_spacing' => $plantSpacing,
                'row_spacing' => $rowSpacing,
                'border_spacing' => $borderSpacing,
                'total_plants' => $totalPlants,
                'plants_per_row' => $plantsPerRow,
                'number_of_rows' => $numberOfRows,
                'effective_area' => round($effectiveArea, 2),
                'planting_density' => round($plantingDensity, 2),
                'space_utilization' => round($spaceUtilization, 1),
                'total_area' => round($areaLength * $areaWidth, 2),
                'input_units' => json_encode([
                    'length_unit' => $validated['lengthUnit'],
                    'width_unit' => $validated['widthUnit'],
                    'border_unit' => $validated['borderUnit'],
                    'auto_border' => $validated['autoBorder']
                ]),
                'is_saved' => false,
            ];

            $calculation = DB::transaction(function () use ($calculationData) {
                // Log the data being saved for debugging
                logger()->info('Saving Square calculation data:', $calculationData);

                $calculation = PlantCalculation::create($calculationData);

                logger()->info('Square calculation saved successfully with ID: ' . $calculation->id);

                // User totals will be updated automatically via model events
                return $calculation;
            });

            // Notify user that calculation was saved
            try {
                $request->user()?->notify(new GenericNotification(
                    title: 'Calculation saved',
                    message: 'Your Square calculation "' . ($calculation->calculation_name ?? 'Unnamed') . '" was saved to your history.',
                    icon: 'calculator',
                    url: route('calculations.history')
                ));
            } catch (\Throwable $e) {
                // Do not interrupt the normal flow if notifications fail
                logger()->warning('Failed to send calculation saved notification: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Calculation saved successfully',
                'calculation_id' => $calculation->id
            ]);

        } catch (\Exception $saveError) {
            // Log the error with more details
            logger()->error('Failed to save Square calculation: ' . $saveError->getMessage(), [
                'error' => $saveError->getMessage(),
                'trace' => $saveError->getTraceAsString(),
                'data' => $calculationData ?? []
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to save calculation: ' . $saveError->getMessage()
            ], 500);
        }
    }
}