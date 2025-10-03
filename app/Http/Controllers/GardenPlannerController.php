<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GardenPlan;
use Illuminate\Support\Facades\Validator;

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
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $plan = GardenPlan::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'layout_data' => $request->layout_data ? json_decode($request->layout_data, true) : null,
            'total_area' => $request->total_area,
        ]);

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
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $plan->update([
            'name' => $request->name,
            'description' => $request->description,
            'layout_data' => $request->layout_data ? json_decode($request->layout_data, true) : null,
            'total_area' => $request->total_area,
        ]);

        return response()->json(['success' => true, 'plan' => $plan]);
    }

    public function delete($id)
    {
        $plan = GardenPlan::where('user_id', auth()->id())->findOrFail($id);
        $plan->delete();

        return response()->json(['success' => true]);
    }
}
