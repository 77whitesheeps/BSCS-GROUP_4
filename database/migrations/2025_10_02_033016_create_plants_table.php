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
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('scientific_name')->nullable();
            $table->string('category', 100);
            $table->decimal('spacing_cm', 8, 2);
            $table->decimal('planting_depth_cm', 8, 2)->nullable();
            $table->integer('days_to_maturity')->nullable();
            $table->string('sunlight_requirements', 100)->nullable();
            $table->string('water_requirements', 100)->nullable();
            $table->decimal('soil_ph_min', 3, 1)->nullable();
            $table->decimal('soil_ph_max', 3, 1)->nullable();
            $table->text('description')->nullable();
            $table->text('care_instructions')->nullable();
            $table->string('season', 50)->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
