<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlantTypeToPlantCalculationsTable extends Migration
{
    public function up()
    {
        Schema::table('plant_calculations', function (Blueprint $table) {
            // Remove or comment out the following line to prevent duplicate column error
            // $table->string('plant_type')->nullable();
        });
    }

    public function down()
    {
        Schema::table('plant_calculations', function (Blueprint $table) {
            $table->dropColumn('plant_type');
        });
    }
}