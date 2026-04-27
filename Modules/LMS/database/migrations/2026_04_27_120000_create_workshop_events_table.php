<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workshop_events', function (Blueprint $table) {
            $table->id();
            $table->enum('page', ['free_resources', 'workshop'])->index();
            $table->string('title');
            $table->string('image')->nullable();
            $table->string('video_url')->nullable();
            $table->text('description')->nullable();
            $table->date('event_date')->nullable();
            $table->string('location')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workshop_events');
    }
};
