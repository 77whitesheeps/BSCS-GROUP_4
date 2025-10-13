<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GardenPlan extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'layout_data',
        'total_area',
        // Calculator Integration
        'plant_calculations',
        // Seasonal Planning
        'seasonal_schedule',
        'growing_season',
        // Irrigation & Water Management
        'irrigation_plan',
        'estimated_water_usage',
        // Soil Management
        'soil_requirements',
        'soil_test_results',
        'fertilizer_schedule',
        // Crop Rotation & Companion Planting
        'crop_rotation_plan',
        'companion_planting',
        // Plant Health & Maintenance
        'pest_management',
        'disease_prevention',
        // Harvest & Yield Tracking
        'harvest_schedule',
        'expected_yield',
        'yield_tracking',
        // Environmental Factors
        'climate_zone',
        'weather_considerations',
        // Resource Planning
        'tool_requirements',
        'supply_list',
        'estimated_cost',
        // Progress Tracking
        'task_checklist',
        'notes',
        'status',
    ];

    protected $casts = [
        'layout_data' => 'array',
        'total_area' => 'decimal:2',
        // Calculator Integration
        'plant_calculations' => 'array',
        // Seasonal Planning
        'seasonal_schedule' => 'array',
        // Irrigation & Water Management
        'irrigation_plan' => 'array',
        'estimated_water_usage' => 'decimal:2',
        // Soil Management
        'soil_requirements' => 'array',
        'soil_test_results' => 'array',
        'fertilizer_schedule' => 'array',
        // Crop Rotation & Companion Planting
        'crop_rotation_plan' => 'array',
        'companion_planting' => 'array',
        // Plant Health & Maintenance
        'pest_management' => 'array',
        'disease_prevention' => 'array',
        // Harvest & Yield Tracking
        'harvest_schedule' => 'array',
        'expected_yield' => 'decimal:2',
        'yield_tracking' => 'array',
        // Environmental Factors
        'weather_considerations' => 'array',
        // Resource Planning
        'tool_requirements' => 'array',
        'supply_list' => 'array',
        'estimated_cost' => 'decimal:2',
        // Progress Tracking
        'task_checklist' => 'array',
    ];

    protected static function booted()
    {
        static::created(function ($plan) {
            $plan->updateUserTotals();
        });

        static::updated(function ($plan) {
            $plan->updateUserTotals();
        });

        static::deleted(function ($plan) {
            $plan->updateUserTotals();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the completion percentage of the garden plan
     */
    public function getCompletionPercentageAttribute(): int
    {
        if (!$this->task_checklist) {
            return 0;
        }

        $totalTasks = count($this->task_checklist);
        if ($totalTasks === 0) {
            return 0;
        }

        $completedTasks = collect($this->task_checklist)->where('completed', true)->count();
        return round(($completedTasks / $totalTasks) * 100);
    }

    /**
     * Get the status color for UI display
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'planning' => 'secondary',
            'planted' => 'info',
            'growing' => 'warning',
            'harvesting' => 'success',
            'completed' => 'primary',
            default => 'secondary'
        };
    }

    /**
     * Check if the plan has any calculations attached
     */
    public function hasCalculations(): bool
    {
        return !empty($this->plant_calculations);
    }

    /**
     * Get total estimated plants from calculations
     */
    public function getTotalEstimatedPlantsAttribute(): int
    {
        if (!$this->plant_calculations) {
            return 0;
        }

        return collect($this->plant_calculations)
            ->sum(function ($calc) {
                return $calc['total_plants'] ?? 0;
            });
    }

    private function updateUserTotals()
    {
        $user = $this->user;

        $plans = $user->gardenPlans;

        $user->total_plans = $plans->count();
        $user->total_garden_area_planned = $plans->sum('total_area');

        $user->save();
    }
}
