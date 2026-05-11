<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds `free_trial_days` to course_settings so admin/instructor can mark a
 * paid course as offering an N-day free trial (e.g. 7 days). Default 0 = no trial.
 *
 * Enrollment / access-gate logic must read this column when granting trial
 * access — see app/Http/Controllers/Frontend/EnrollmentController.php (TBD).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('course_settings', 'free_trial_days')) {
                $table->unsignedInteger('free_trial_days')
                    ->default(0)
                    ->after('is_free')
                    ->comment('Number of days a student gets free trial access to a paid course. 0 = no trial.');
            }
        });
    }

    public function down(): void
    {
        Schema::table('course_settings', function (Blueprint $table) {
            if (Schema::hasColumn('course_settings', 'free_trial_days')) {
                $table->dropColumn('free_trial_days');
            }
        });
    }
};
