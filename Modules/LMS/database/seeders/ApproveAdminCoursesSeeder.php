<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Enums\CourseStatus;
use Modules\LMS\Models\Courses\Course;

/**
 * One-off: publish the courses the admin already created but which were stuck
 * in "Pending" (the catalogue only shows Approved courses, so they were
 * invisible). Only touches ADMIN-created courses (admin_id is not null);
 * instructor/organization submissions are left as Pending for review.
 *
 * Safe to re-run.
 */
class ApproveAdminCoursesSeeder extends Seeder
{
    public function run(): void
    {
        $count = Course::whereNotNull('admin_id')
            ->where('status', CourseStatus::PENDING)
            ->update(['status' => CourseStatus::APPROVED]);

        $this->command?->info("Approved {$count} admin-created course(s).");
    }
}
