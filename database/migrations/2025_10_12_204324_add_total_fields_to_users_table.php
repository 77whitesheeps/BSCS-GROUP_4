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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('total_calculations')->default(0)->after('email');
            $table->integer('total_plant_types')->default(0)->after('total_calculations');
            $table->integer('total_plants_calculated')->default(0)->after('total_plant_types');
            $table->decimal('total_area_planned', 10, 2)->default(0)->after('total_plants_calculated');
            $table->integer('total_plans')->default(0)->after('total_area_planned');
            $table->decimal('total_garden_area_planned', 10, 2)->default(0)->after('total_plans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['total_calculations', 'total_plant_types', 'total_plants_calculated', 'total_area_planned', 'total_plans', 'total_garden_area_planned']);
        });
    }
};
