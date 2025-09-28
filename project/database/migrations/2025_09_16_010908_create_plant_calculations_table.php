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
        Schema::create('plant_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('plant_type')->nullable();
            $table->decimal('area_length', 10, 2);
            $table->string('area_length_unit', 20);
            $table->decimal('area_width', 10, 2);
            $table->string('area_width_unit', 20);
            $table->decimal('plant_spacing', 8, 2);
            $table->string('plant_spacing_unit', 20);
            $table->decimal('border_spacing', 8, 2)->default(0);
            $table->string('border_spacing_unit', 20)->default('m');
            $table->integer('total_plants');
            $table->integer('rows');
            $table->integer('columns');
            $table->decimal('effective_length', 10, 2);
            $table->decimal('effective_width', 10, 2);
            $table->decimal('total_area', 12, 4); // Total area in square meters
            $table->string('calculation_name')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_calculations');
    }
};
