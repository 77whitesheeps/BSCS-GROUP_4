<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GardenPlan;
use Illuminate\Support\Facades\Validator;
use App\Notifications\GenericNotification;

class GardenPlannerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $plans = GardenPlan::where('user_id', $user->id)->latest()->get();

        return view('garden-planner', compact('plans'));
    }

    public function show($id)
    {
        $plan = GardenPlan::where('user_id', auth()->id())->findOrFail($id);

        return response()->json($plan);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'layout_data' => 'nullable|json',
            'total_area' => 'nullable|numeric|min:0',
            'growing_season' => 'nullable|string|in:spring,summer,fall,winter,year-round',
            'climate_zone' => 'nullable|string|max:50',
            'plant_calculations' => 'nullable|json',
            'seasonal_schedule' => 'nullable|json',
            'irrigation_plan' => 'nullable|json',
            'estimated_water_usage' => 'nullable|numeric|min:0',
            'soil_requirements' => 'nullable|json',
            'fertilizer_schedule' => 'nullable|json',
            'tool_requirements' => 'nullable|json',
            'expected_yield' => 'nullable|numeric|min:0',
            'estimated_cost' => 'nullable|numeric|min:0',
            'task_checklist' => 'nullable|json',
            'notes' => 'nullable|string',
            'status' => 'nullable|string|in:planning,planted,growing,harvesting,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $planData = [
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'layout_data' => $request->layout_data ? json_decode($request->layout_data, true) : null,
            'total_area' => $request->total_area,
            'growing_season' => $request->growing_season,
            'climate_zone' => $request->climate_zone,
            'plant_calculations' => $request->plant_calculations ? json_decode($request->plant_calculations, true) : null,
            'seasonal_schedule' => $request->seasonal_schedule ? json_decode($request->seasonal_schedule, true) : null,
            'irrigation_plan' => $request->irrigation_plan ? json_decode($request->irrigation_plan, true) : null,
            'estimated_water_usage' => $request->estimated_water_usage,
            'soil_requirements' => $request->soil_requirements ? json_decode($request->soil_requirements, true) : null,
            'fertilizer_schedule' => $request->fertilizer_schedule ? json_decode($request->fertilizer_schedule, true) : null,
            'tool_requirements' => $request->tool_requirements ? json_decode($request->tool_requirements, true) : null,
            'expected_yield' => $request->expected_yield,
            'estimated_cost' => $request->estimated_cost,
            'task_checklist' => $request->task_checklist ? json_decode($request->task_checklist, true) : null,
            'notes' => $request->notes,
            'status' => $request->status ?? 'planning',
        ];

        $plan = GardenPlan::create($planData);

        // Notify user of new plan
        try {
            $request->user()?->notify(new GenericNotification(
                title: 'Garden plan created',
                message: '"' . $plan->name . '" has been created successfully.',
                icon: 'leaf',
                url: route('garden.planner')
            ));
        } catch (\Throwable $e) {
            logger()->warning('Failed to send plan created notification: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'plan' => $plan]);
    }

    public function update(Request $request, $id)
    {
        $plan = GardenPlan::where('user_id', auth()->id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'layout_data' => 'nullable|json',
            'total_area' => 'nullable|numeric|min:0',
            'growing_season' => 'nullable|string|in:spring,summer,fall,winter,year-round',
            'climate_zone' => 'nullable|string|max:50',
            'plant_calculations' => 'nullable|json',
            'seasonal_schedule' => 'nullable|json',
            'irrigation_plan' => 'nullable|json',
            'estimated_water_usage' => 'nullable|numeric|min:0',
            'soil_requirements' => 'nullable|json',
            'fertilizer_schedule' => 'nullable|json',
            'tool_requirements' => 'nullable|json',
            'expected_yield' => 'nullable|numeric|min:0',
            'estimated_cost' => 'nullable|numeric|min:0',
            'task_checklist' => 'nullable|json',
            'notes' => 'nullable|string',
            'status' => 'nullable|string|in:planning,planted,growing,harvesting,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $updateData = [
            'name' => $request->name,
            'description' => $request->description,
            'layout_data' => $request->layout_data ? json_decode($request->layout_data, true) : null,
            'total_area' => $request->total_area,
            'growing_season' => $request->growing_season,
            'climate_zone' => $request->climate_zone,
            'plant_calculations' => $request->plant_calculations ? json_decode($request->plant_calculations, true) : null,
            'seasonal_schedule' => $request->seasonal_schedule ? json_decode($request->seasonal_schedule, true) : null,
            'irrigation_plan' => $request->irrigation_plan ? json_decode($request->irrigation_plan, true) : null,
            'estimated_water_usage' => $request->estimated_water_usage,
            'soil_requirements' => $request->soil_requirements ? json_decode($request->soil_requirements, true) : null,
            'fertilizer_schedule' => $request->fertilizer_schedule ? json_decode($request->fertilizer_schedule, true) : null,
            'tool_requirements' => $request->tool_requirements ? json_decode($request->tool_requirements, true) : null,
            'expected_yield' => $request->expected_yield,
            'estimated_cost' => $request->estimated_cost,
            'task_checklist' => $request->task_checklist ? json_decode($request->task_checklist, true) : null,
            'notes' => $request->notes,
            'status' => $request->status ?? $plan->status,
        ];

        $plan->update($updateData);

        // Notify user of plan update
        try {
            $request->user()?->notify(new GenericNotification(
                title: 'Garden plan updated',
                message: 'Your plan "' . $plan->name . '" was updated.',
                icon: 'edit',
                url: route('garden.planner')
            ));
        } catch (\Throwable $e) {
            logger()->warning('Failed to send plan updated notification: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'plan' => $plan]);
    }

    public function delete($id)
    {
        $plan = GardenPlan::where('user_id', auth()->id())->findOrFail($id);
        $planName = $plan->name;
        $plan->delete();

        // Notify user of deletion
        try {
            auth()->user()?->notify(new GenericNotification(
                title: 'Garden plan deleted',
                message: 'Your plan "' . $planName . '" was deleted.',
                icon: 'trash',
                url: route('garden.planner')
            ));
        } catch (\Throwable $e) {
            logger()->warning('Failed to send plan deleted notification: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }

    /**
     * Import calculation results from plant calculators
     */
    public function importCalculation(Request $request, $id)
    {
        $plan = GardenPlan::where('user_id', auth()->id())->findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'calculation_data' => 'required|array',
            'calculation_data.plant_type' => 'required|string',
            'calculation_data.total_plants' => 'required|integer|min:1',
            'calculation_data.area_length' => 'required|numeric|min:0.1',
            'calculation_data.area_width' => 'required|numeric|min:0.1',
            'calculation_data.plant_spacing' => 'required|numeric|min:0.1',
            'calculation_data.method' => 'required|string|in:square,triangular,quincunx',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $calculations = $plan->plant_calculations ?? [];
        $calculations[] = $request->calculation_data;
        
        $plan->update(['plant_calculations' => $calculations]);

        // Notify user of calculation import
        try {
            $request->user()?->notify(new GenericNotification(
                title: 'Calculation imported to plan',
                message: 'A ' . ($request->calculation_data['method'] ?? 'plant') . ' calculation was added to "' . $plan->name . '".',
                icon: 'file-import',
                url: route('garden.planner')
            ));
        } catch (\Throwable $e) {
            logger()->warning('Failed to send calculation import notification: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'plan' => $plan]);
    }

    /**
     * Update task status in a plan
     */
    public function updateTaskStatus(Request $request, $id)
    {
        $plan = GardenPlan::where('user_id', auth()->id())->findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'task_index' => 'required|integer|min:0',
            'completed' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tasks = $plan->task_checklist ?? [];
        if (isset($tasks[$request->task_index])) {
            $tasks[$request->task_index]['completed'] = $request->completed;
            $plan->update(['task_checklist' => $tasks]);

            // Notify user of task status change
            try {
                $title = $request->completed ? 'Task completed' : 'Task re-opened';
                $request->user()?->notify(new GenericNotification(
                    title: $title,
                    message: 'A task in "' . $plan->name . '" was ' . ($request->completed ? 'completed' : 're-opened') . '.',
                    icon: $request->completed ? 'check-circle' : 'undo',
                    url: route('garden.planner')
                ));
            } catch (\Throwable $e) {
                logger()->warning('Failed to send task status notification: ' . $e->getMessage());
            }
        }

        return response()->json(['success' => true, 'plan' => $plan->fresh()]);
    }

    /**
     * Get comprehensive statistics for all user plans
     */
    public function getStatistics()
    {
        $user = auth()->user();
        $plans = GardenPlan::where('user_id', $user->id)->get();

        $stats = [
            'total_plans' => $plans->count(),
            'total_area_planned' => $plans->sum('total_area'),
            'total_expected_yield' => $plans->sum('expected_yield'),
            'total_estimated_cost' => $plans->sum('estimated_cost'),
            'total_estimated_plants' => $plans->sum(function ($plan) {
                return $plan->total_estimated_plants;
            }),
            'plans_by_status' => $plans->groupBy('status')->map->count(),
            'average_completion' => $plans->avg(function ($plan) {
                return $plan->completion_percentage;
            }),
        ];

        return response()->json($stats);
    }
}
