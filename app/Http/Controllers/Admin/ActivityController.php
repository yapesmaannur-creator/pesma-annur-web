<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::latest('date');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $submissions_count = [
            'all' => Activity::count(),
            'upcoming' => Activity::where('status', 'upcoming')->count(),
            'ongoing' => Activity::where('status', 'ongoing')->count(),
            'completed' => Activity::where('status', 'completed')->count(),
        ];

        $activities = $query->paginate(10)->appends($request->query());
        return view('admin.activities.index', compact('activities', 'submissions_count'));
    }

    public function show(Activity $activity)
    {
        return view('admin.activities.show', compact('activity'));
    }

    public function create()
    {
        return view('admin.activities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'time_start' => 'nullable|date_format:H:i',
            'time_end' => 'nullable|date_format:H:i',
            'organizer' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'registration_link' => 'nullable|url|max:500',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'nullable|in:upcoming,ongoing,completed,cancelled',
            'created_at' => 'nullable|date',
            'image' => 'nullable|image|max:3072',
            'is_active' => 'nullable|boolean',
        ]);

        $activity = new Activity($request->except('image', 'is_active', 'created_at'));
        $activity->slug = Str::slug($request->title);
        $activity->is_active = $request->has('is_active');
        $activity->status = $request->status ?? 'upcoming';

        if ($request->filled('created_at')) {
            $activity->created_at = \Carbon\Carbon::parse($request->created_at);
        }

        if ($request->hasFile('image')) {
            $activity->image = $request->file('image')->store('activities', 'public');
        }

        $activity->save();

        return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'time_start' => 'nullable|date_format:H:i',
            'time_end' => 'nullable|date_format:H:i',
            'organizer' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'registration_link' => 'nullable|url|max:500',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'nullable|in:upcoming,ongoing,completed,cancelled',
            'created_at' => 'nullable|date',
            'image' => 'nullable|image|max:3072',
            'is_active' => 'nullable|boolean',
        ]);

        $activity->fill($request->except('image', 'is_active', 'created_at'));
        $activity->is_active = $request->has('is_active');
        $activity->status = $request->status ?? $activity->status;
        
        if ($request->filled('created_at')) {
            $activity->created_at = \Carbon\Carbon::parse($request->created_at);
        }

        if ($request->title !== $activity->getOriginal('title')) {
            $activity->slug = Str::slug($request->title);
        }

        if ($request->hasFile('image')) {
            if ($activity->image && Storage::disk('public')->exists($activity->image)) {
                Storage::disk('public')->delete($activity->image);
            }
            $activity->image = $request->file('image')->store('activities', 'public');
        }

        $activity->save();

        return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $activity)
    {
        if ($activity->image && Storage::disk('public')->exists($activity->image)) {
            Storage::disk('public')->delete($activity->image);
        }
        $activity->delete();
        return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
