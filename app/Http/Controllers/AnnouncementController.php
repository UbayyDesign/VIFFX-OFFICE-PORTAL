<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $announcements = Announcement::latest()->paginate(12);

        return view('announcements.index', [
            'announcements' => $announcements,
        ]);
    }

    public function create()
    {
        return view('announcements.create', [
            'announcement' => new Announcement(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:4'],
            'icon_bg' => ['nullable', 'string', 'max:64'],
            'is_new' => ['nullable', 'boolean'],
        ]);

        Announcement::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'icon' => $validated['icon'] ?? '📢',
            'icon_bg' => $validated['icon_bg'] ?? 'bg-yellow-500/15',
            'is_new' => $validated['is_new'] ?? false,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('announcements.index')->with('success', 'Announcement berhasil disimpan.');
    }

    public function show(Announcement $announcement)
    {
        return view('announcements.show', [
            'announcement' => $announcement,
        ]);
    }

    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', [
            'announcement' => $announcement,
        ]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:4'],
            'icon_bg' => ['nullable', 'string', 'max:64'],
            'is_new' => ['nullable', 'boolean'],
        ]);

        $announcement->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'icon' => $validated['icon'] ?? $announcement->icon,
            'icon_bg' => $validated['icon_bg'] ?? $announcement->icon_bg,
            'is_new' => $validated['is_new'] ?? false,
        ]);

        return redirect()->route('announcements.index')->with('success', 'Announcement berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Announcement berhasil dihapus.');
    }
}
