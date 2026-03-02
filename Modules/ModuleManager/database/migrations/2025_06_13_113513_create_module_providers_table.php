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
        Schema::create('module_providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->string('provider_class')->nullable();
            $table->json('additional_providers')->nullable();
            $table->json('aliases')->nullable();
            $table->json('middleware')->nullable();
            $table->json('route_middleware')->nullable();
            $table->json('migration_files')->nullable();
            $table->json('menu_items')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_providers');
    }
};
