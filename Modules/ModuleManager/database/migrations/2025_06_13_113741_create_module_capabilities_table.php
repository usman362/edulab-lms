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
        Schema::create('module_capabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->boolean('is_installable')->default(true);
            $table->boolean('is_upgradable')->default(true);
            $table->boolean('is_removable')->default(true);
            $table->boolean('is_configurable')->default(true);
            $table->boolean('is_cacheable')->default(true);
            $table->boolean('is_loggable')->default(true);
            $table->boolean('is_monitorable')->default(true);
            $table->boolean('is_auditable')->default(true);
            $table->boolean('is_customizable')->default(false);
            $table->boolean('is_legacy')->default(false);
            $table->boolean('is_protected')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_capabilities');
    }
};
