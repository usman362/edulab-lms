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
        Schema::create('module_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->boolean('requires_activation')->default(true);
            $table->boolean('supports_tenancy')->default(false);
            $table->boolean('has_migrations')->default(false);
            $table->boolean('has_seeds')->default(false);
            $table->boolean('has_assets')->default(false);
            $table->boolean('has_settings')->default(false);
            $table->boolean('has_admin_settings')->default(false);
            $table->boolean('has_tenant_settings')->default(false);
            $table->boolean('is_multitenant')->default(false);
            $table->boolean('is_translatable')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_features');
    }
};
