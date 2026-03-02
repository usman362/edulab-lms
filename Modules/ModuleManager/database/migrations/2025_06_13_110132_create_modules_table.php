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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('alias')->unique();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('version')->default('1.0.0');
            $table->string('status')->default('inactive'); // active, inactive, deprecated
            $table->string('type')->default('feature'); // feature, integration, theme, etc.
            $table->json('providers')->nullable(); // Service providers
            $table->json('files')->nullable();
            $table->json('requires')->nullable();
            $table->json('keywords')->nullable(); // Other modules this module depends on
            $table->string('category')->nullable(); // utility, feature, etc.
            $table->dateTime('installed_at')->nullable();
            $table->dateTime('last_updated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
