<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCalculationTypeToPlantCalculationsTable extends Migration
{
    public function up()
    {
        Schema::table('plant_calculations', function (Blueprint $table) {
            $table->string('calculation_type')->nullable(); // Using nullable() if existing records don't have a type
        });
    }

    public function down()
    {
        Schema::table('plant_calculations', function (Blueprint $table) {
            $table->dropColumn('calculation_type');
        });
    }
}