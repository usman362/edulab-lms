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
        Schema::create('module_metadata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->string('author')->nullable();
            $table->string('author_url')->nullable();
            $table->string('website')->nullable();
            $table->integer('priority')->default(0);
            $table->string('license')->nullable();
            $table->string('license_type')->nullable(); // MIT, GPL, etc.
            $table->string('icon')->nullable();
            $table->text('changelog')->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable(); // Additional metadata
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_metadata');
    }
};
