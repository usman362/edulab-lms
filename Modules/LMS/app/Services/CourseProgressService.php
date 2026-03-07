<?php

namespace Modules\LMS\Services;

use Illuminate\Support\Facades\DB;
use Modules\LMS\Models\Purchase\PurchaseDetails;

class CourseProgressService
{
    /**
     * Mark a topic as completed for a user (quiz/assignment submitted).
     */
    public static function markTopicCompleted(int $userId, int $topicId): void
    {
        $table = 'user_topic_progress';
        if (!\Illuminate\Support\Facades\Schema::hasTable($table)) {
            return;
        }
        DB::table($table)->insertOrIgnore([
            'user_id' => $userId,
            'topic_id' => $topicId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Recalculate and update progress_percentage for a user's course enrollment.
     */
    public static function updateProgressPercentage(int $userId, int $courseId): void
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('user_topic_progress')) {
            return;
        }
        $totalTopics = DB::table('topics')->where('course_id', $courseId)->count();
        if ($totalTopics === 0) {
            return;
        }
        $completed = DB::table('user_topic_progress')
            ->where('user_id', $userId)
            ->whereIn('topic_id', function ($q) use ($courseId) {
                $q->select('id')->from('topics')->where('course_id', $courseId);
            })
            ->count();
        $percentage = (int) round(($completed / $totalTopics) * 100);
        PurchaseDetails::where([
            'user_id' => $userId,
            'course_id' => $courseId,
            'type' => 'enrolled',
            'purchase_type' => 'course',
        ])->update(['progress_percentage' => min(100, $percentage)]);
    }

    /**
     * Get progress percentage for a user's course (from DB or computed).
     */
    public static function getProgressPercentage(int $userId, int $courseId): int
    {
        $detail = PurchaseDetails::where([
            'user_id' => $userId,
            'course_id' => $courseId,
            'type' => 'enrolled',
            'purchase_type' => 'course',
        ])->first();
        return (int) ($detail->progress_percentage ?? 0);
    }
}
