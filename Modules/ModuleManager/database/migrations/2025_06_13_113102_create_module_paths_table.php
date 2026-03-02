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
        Schema::create('module_paths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->string('namespace')->nullable();
            $table->string('path')->nullable();
            $table->string('composer_json_path')->nullable();
            $table->string('config_path')->nullable();
            $table->string('migration_path')->nullable();
            $table->string('route_path')->nullable();
            $table->string('view_path')->nullable();
            $table->string('translation_path')->nullable();
            $table->string('service_provider')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_paths');
    }
};
