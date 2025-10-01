<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantCalculationsTable extends Migration
{
    public function up()
    {
        Schema::create('plant_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('calculation_type', ['square', 'triangular', 'quincunx']);
            $table->decimal('area_length', 10, 2);
            $table->decimal('area_width', 10, 2);
            $table->decimal('plant_spacing', 10, 2);
            $table->decimal('row_spacing', 10, 2);
            $table->decimal('border_spacing', 10, 2);
            $table->integer('total_plants');
            $table->integer('plants_per_row');
            $table->integer('number_of_rows');
            $table->decimal('effective_area', 10, 2);
            $table->decimal('planting_density', 10, 2);
            $table->decimal('space_utilization', 5, 2);
            $table->text('input_units')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plant_calculations');
    }
}