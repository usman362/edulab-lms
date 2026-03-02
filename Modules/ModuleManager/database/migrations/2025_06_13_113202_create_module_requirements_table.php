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
        Schema::create('module_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->string('min_php_version')->nullable();
            $table->string('max_php_version')->nullable();
            $table->string('min_laravel_version')->nullable();
            $table->string('max_laravel_version')->nullable();
            $table->string('min_core_version')->nullable();
            $table->string('max_core_version')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_requirements');
    }
};
