<?php

namespace Modules\LMS\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\LMS\Models\WorkshopEvent;

class WorkshopEventController extends Controller
{
    private const FOLDER = 'lms/workshop-events';

    public function index(Request $request)
    {
        $page = $request->get('page_filter', 'workshop');
        if (!in_array($page, ['workshop', 'free_resources'])) {
            $page = 'workshop';
        }
        $events = WorkshopEvent::where('page', $page)
            ->orderBy('sort_order')
            ->orderByDesc('event_date')
            ->latest()
            ->get();

        return view('portal::admin.workshop-event.index', compact('events', 'page'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'page'        => 'required|in:workshop,free_resources',
            'title'       => 'required|string|max:255',
            'image'       => 'nullable|image|max:5120',
            'video_url'   => 'nullable|url|max:500',
            'description' => 'nullable|string',
            'event_date'  => 'nullable|date',
            'location'    => 'nullable|string|max:255',
            'sort_order'  => 'nullable|integer|min:0',
            'status'      => 'nullable|boolean',
        ]);

        $validated['image'] = $this->uploadImage($request);
        $validated['status'] = $request->boolean('status', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        WorkshopEvent::create($validated);

        return redirect()->route('workshop-event.index', ['page_filter' => $validated['page']])
            ->with('success', translate('Saved successfully'));
    }

    public function update(Request $request, $id)
    {
        $event = WorkshopEvent::findOrFail($id);

        $validated = $request->validate([
            'page'        => 'required|in:workshop,free_resources',
            'title'       => 'required|string|max:255',
            'image'       => 'nullable|image|max:5120',
            'video_url'   => 'nullable|url|max:500',
            'description' => 'nullable|string',
            'event_date'  => 'nullable|date',
            'location'    => 'nullable|string|max:255',
            'sort_order'  => 'nullable|integer|min:0',
            'status'      => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk($this->disk())->delete('public/' . self::FOLDER . '/' . $event->image);
            }
            $validated['image'] = $this->uploadImage($request);
        } else {
            unset($validated['image']);
        }

        $validated['status'] = $request->boolean('status', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $event->update($validated);

        return redirect()->route('workshop-event.index', ['page_filter' => $validated['page']])
            ->with('success', translate('Updated successfully'));
    }

    public function destroy($id)
    {
        $event = WorkshopEvent::findOrFail($id);
        if ($event->image) {
            Storage::disk($this->disk())->delete('public/' . self::FOLDER . '/' . $event->image);
        }
        $page = $event->page;
        $event->delete();

        return redirect()->route('workshop-event.index', ['page_filter' => $page])
            ->with('success', translate('Deleted successfully'));
    }

    private function uploadImage(Request $request): ?string
    {
        if (!$request->hasFile('image')) {
            return null;
        }
        $file = $request->file('image');
        $name = 'we-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        Storage::disk($this->disk())->putFileAs('public/' . self::FOLDER, $file, $name);
        return $name;
    }

    private function disk(): string
    {
        return is_tenant_context() ? 'local' : 'LMS';
    }
}
