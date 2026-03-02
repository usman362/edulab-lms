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
        Schema::create('module_customization_paths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->string('customization_path')->nullable();
            $table->string('customization_namespace')->nullable();
            $table->string('customization_config_path')->nullable();
            $table->string('customization_view_path')->nullable();
            $table->string('customization_route_path')->nullable();
            $table->string('customization_translation_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_customization_paths');
    }
};
