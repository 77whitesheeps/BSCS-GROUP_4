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
        Schema::create('export_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('format'); // csv, pdf, json
            $table->integer('record_count');
            $table->string('file_size')->nullable();
            $table->string('status')->default('completed'); // completed, failed, processing
            $table->json('filters')->nullable(); // Store the export filters used
            $table->string('file_path')->nullable(); // If you store files locally
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('export_logs');
    }
};
