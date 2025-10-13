<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('garden_plans', function (Blueprint $table) {
            // Calculator Integration
            $table->json('plant_calculations')->nullable()->after('layout_data'); // Store multiple calculation results
            
            // Seasonal Planning
            $table->json('seasonal_schedule')->nullable()->after('plant_calculations'); // Planting/harvesting schedule
            $table->string('growing_season')->nullable()->after('seasonal_schedule'); // Spring, Summer, Fall, Winter
            
            // Irrigation & Water Management
            $table->json('irrigation_plan')->nullable()->after('growing_season'); // Watering schedule and zones
            $table->decimal('estimated_water_usage', 8, 2)->nullable()->after('irrigation_plan'); // Liters per week
            
            // Soil Management
            $table->json('soil_requirements')->nullable()->after('estimated_water_usage'); // pH, nutrients, soil type
            $table->json('soil_test_results')->nullable()->after('soil_requirements'); // Test results tracking
            $table->json('fertilizer_schedule')->nullable()->after('soil_test_results'); // Fertilization plan
            
            // Crop Rotation & Companion Planting
            $table->json('crop_rotation_plan')->nullable()->after('fertilizer_schedule'); // Multi-year rotation
            $table->json('companion_planting')->nullable()->after('crop_rotation_plan'); // Beneficial plant combinations
            
            // Plant Health & Maintenance
            $table->json('pest_management')->nullable()->after('companion_planting'); // Pest control strategies
            $table->json('disease_prevention')->nullable()->after('pest_management'); // Disease prevention measures
            
            // Harvest & Yield Tracking
            $table->json('harvest_schedule')->nullable()->after('disease_prevention'); // Expected harvest dates
            $table->decimal('expected_yield', 8, 2)->nullable()->after('harvest_schedule'); // kg or units expected
            $table->json('yield_tracking')->nullable()->after('expected_yield'); // Actual vs expected yields
            
            // Environmental Factors
            $table->string('climate_zone')->nullable()->after('yield_tracking'); // Hardiness zone
            $table->json('weather_considerations')->nullable()->after('climate_zone'); // Weather-specific notes
            
            // Resource Planning
            $table->json('tool_requirements')->nullable()->after('weather_considerations'); // Required tools/equipment
            $table->json('supply_list')->nullable()->after('tool_requirements'); // Seeds, fertilizers, etc.
            $table->decimal('estimated_cost', 10, 2)->nullable()->after('supply_list'); // Total estimated cost
            
            // Progress Tracking
            $table->json('task_checklist')->nullable()->after('estimated_cost'); // Garden maintenance tasks
            $table->text('notes')->nullable()->after('task_checklist'); // Additional planning notes
            $table->enum('status', ['planning', 'planted', 'growing', 'harvesting', 'completed'])->default('planning')->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('garden_plans', function (Blueprint $table) {
            $table->dropColumn([
                'plant_calculations',
                'seasonal_schedule',
                'growing_season',
                'irrigation_plan',
                'estimated_water_usage',
                'soil_requirements',
                'soil_test_results',
                'fertilizer_schedule',
                'crop_rotation_plan',
                'companion_planting',
                'pest_management',
                'disease_prevention',
                'harvest_schedule',
                'expected_yield',
                'yield_tracking',
                'climate_zone',
                'weather_considerations',
                'tool_requirements',
                'supply_list',
                'estimated_cost',
                'task_checklist',
                'notes',
                'status'
            ]);
        });
    }
};
