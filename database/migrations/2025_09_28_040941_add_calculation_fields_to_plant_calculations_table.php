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
            // The calculation_type column already exists, so we'll add other fields
            $table->string('calculation_name')->nullable()->after('user_id');
            $table->text('notes')->nullable();
            $table->boolean('is_saved')->default(false);
            $table->index(['user_id', 'created_at']);
            $table->index(['user_id', 'is_saved']);
            $table->index(['user_id', 'calculation_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('plant_calculations', function (Blueprint $table) {
            // Drop foreign key first (replace 'fk_name' with your actual foreign key name)
            $table->dropForeign(['user_id']); // or $table->dropForeign('plant_calculations_user_id_foreign');
            // Now drop the index
            $table->dropIndex(['user_id', 'calculation_type']);
        });
    }
};