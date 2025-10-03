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
        Schema::table('plant_calculations', function (Blueprint $table) {
            // Add missing columns that controllers are trying to save
            $table->integer('rows')->nullable()->after('number_of_rows');
            $table->integer('columns')->nullable()->after('plants_per_row');
            $table->decimal('effective_length', 10, 2)->nullable()->after('effective_area');
            $table->decimal('effective_width', 10, 2)->nullable()->after('effective_length');
            $table->decimal('total_area', 10, 2)->nullable()->after('effective_width');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plant_calculations', function (Blueprint $table) {
            $table->dropColumn(['rows', 'columns', 'effective_length', 'effective_width', 'total_area']);
        });
    }
};
