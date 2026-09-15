<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::latest()->paginate(10);
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except(['is_active', 'image']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        $program = new Program($data);
        $program->slug = Str::slug($request->title);
        $program->is_active = $request->has('is_active');
        $program->save();

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil ditambahkan.');
    }

    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except(['is_active', 'image']);
        
        if ($request->hasFile('image')) {
            if ($program->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($program->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($program->image);
            }
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        $program->fill($data);
        $program->is_active = $request->has('is_active');
        
        if ($request->title !== $program->getOriginal('title')) {
            $program->slug = Str::slug($request->title);
        }

        $program->save();

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus.');
    }
}
