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
            $table->string('calculation_type')->default('square')->after('calculation_name');
            $table->boolean('is_saved')->default(false)->after('notes');
            $table->index(['user_id', 'created_at']);
            $table->index(['user_id', 'is_saved']);
            $table->index(['user_id', 'calculation_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plant_calculations', function (Blueprint $table) {
            $table->dropColumn(['calculation_type', 'is_saved']);
            $table->dropIndex(['user_id', 'created_at']);
            $table->dropIndex(['user_id', 'is_saved']);
            $table->dropIndex(['user_id', 'calculation_type']);
        });
    }
};
