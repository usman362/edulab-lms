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
        Schema::create('module_visibilities', function (Blueprint $table) {
             $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_hidden_from_list')->default(false);
            $table->boolean('is_hidden_from_search')->default(false);
            $table->boolean('is_hidden_from_admin')->default(false);
            $table->boolean('is_hidden_from_user')->default(false);
            $table->boolean('is_hidden_from_api')->default(false);
            $table->boolean('is_hidden_from_cli')->default(false);
            $table->boolean('is_hidden_from_web')->default(false);
            $table->boolean('is_hidden_from_mobile')->default(false);
            $table->boolean('is_hidden_from_desktop')->default(false);
            $table->boolean('is_hidden_from_widget')->default(false);
            $table->boolean('is_hidden_from_dashboard')->default(false);
            $table->boolean('is_hidden_from_menu')->default(false);
            $table->boolean('is_hidden_from_toolbar')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_visibilities');
    }
};
