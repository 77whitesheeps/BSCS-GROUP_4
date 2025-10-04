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
            $table->boolean('email_notifications')->default(true);
            $table->string('theme')->default('light');
            $table->string('default_garden_size')->default('square_meters');
            $table->boolean('auto_save_calculations')->default(true);
            $table->string('export_format')->default('pdf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email_notifications', 'theme', 'language', 'default_garden_size', 'auto_save_calculations', 'export_format']);
        });
    }
};
