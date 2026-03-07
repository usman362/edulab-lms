<?php

namespace Modules\LMS\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\LMS\Models\Courses\Topic;
use Modules\LMS\Repositories\Purchase\PurchaseRepository;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Streams course lesson video without exposing direct file URL.
 * Ensures only enrolled users can access; supports Range for seeking.
 * No download — inline streaming only.
 */
class VideoStreamController extends Controller
{
    /**
     * Stream video for a topic. User must be enrolled in the course.
     */
    public function stream(Request $request, int $topicId): StreamedResponse
    {
        $user = authCheck();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $topic = Topic::with('topicable', 'chapter.course')->find($topicId);
        if (!$topic || !$topic->topicable || $topic->topicable_type !== \Modules\LMS\Models\Courses\Topics\Video::class) {
            abort(404, 'Video not found');
        }

        $video = $topic->topicable;
        if ($video->video_src_type !== 'local' || empty($video->system_video)) {
            abort(404, 'Video not available');
        }

        $courseId = $topic->chapter?->course_id;
        if (!$courseId) {
            abort(404, 'Course not found');
        }

        $hasPurchase = PurchaseRepository::getByUserId([
            'user_id' => $user->id,
            'course_id' => $courseId,
        ]);
        if (!$hasPurchase && isStudent()) {
            abort(403, 'You must be enrolled to view this video');
        }

        $folder = 'lms/courses/topics/videos';
        $disk = is_tenant_context() ? 'local' : 'LMS';
        $path = 'public/' . $folder . '/' . $video->system_video;

        if (!Storage::disk($disk)->exists($path)) {
            abort(404, 'File not found');
        }

        $fullPath = Storage::disk($disk)->path($path);
        $filesize = (int) filesize($fullPath);
        $filename = $video->system_video;

        $range = $request->header('Range');
        if ($range) {
            return $this->streamRange($fullPath, $filesize, $filename, $range);
        }

        return $this->streamFull($fullPath, $filesize, $filename);
    }

    private function streamFull(string $fullPath, int $filesize, string $filename): StreamedResponse
    {
        return response()->stream(function () use ($fullPath) {
            $stream = fopen($fullPath, 'rb');
            if ($stream === false) {
                return;
            }
            while (!feof($stream)) {
                echo fread($stream, 8192);
                flush();
            }
            fclose($stream);
        }, 200, [
            'Content-Type' => 'video/mp4',
            'Content-Length' => (string) $filesize,
            'Accept-Ranges' => 'bytes',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Cache-Control' => 'private, no-store',
        ]);
    }

    private function streamRange(string $fullPath, int $filesize, string $filename, string $rangeHeader): StreamedResponse
    {
        if (!preg_match('/bytes=(\d+)-(\d*)/', $rangeHeader, $m)) {
            return $this->streamFull($fullPath, $filesize, $filename);
        }
        $start = (int) $m[1];
        $end = $m[2] === '' ? $filesize - 1 : min((int) $m[2], $filesize - 1);
        $length = $end - $start + 1;

        $stream = fopen($fullPath, 'rb');
        if ($stream === false) {
            abort(500, 'Cannot read file');
        }
        fseek($stream, $start);

        return response()->stream(function () use ($stream, $length) {
            $sent = 0;
            while ($sent < $length && !feof($stream)) {
                $chunk = min(8192, $length - $sent);
                echo fread($stream, $chunk);
                $sent += $chunk;
                flush();
            }
            fclose($stream);
        }, 206, [
            'Content-Type' => 'video/mp4',
            'Content-Length' => (string) $length,
            'Content-Range' => sprintf('bytes %d-%d/%d', $start, $end, $filesize),
            'Accept-Ranges' => 'bytes',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Cache-Control' => 'private, no-store',
        ]);
    }
}
