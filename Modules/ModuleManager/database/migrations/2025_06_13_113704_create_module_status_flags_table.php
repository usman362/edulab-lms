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
        Schema::create('module_status_flags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->boolean('is_core')->default(false);
            $table->boolean('is_enabled')->default(false);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_installed')->default(false);
            $table->boolean('is_deprecated')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_beta')->default(false);
            $table->boolean('is_stable')->default(true);
            $table->boolean('is_experimental')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_status_flags');
    }
};
