<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'created_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        $page = new Page($request->except('is_active', 'created_at'));
        $page->slug = Str::slug($request->title);
        $page->is_active = $request->has('is_active');
        if ($request->filled('created_at')) {
            $page->created_at = \Carbon\Carbon::parse($request->created_at);
        }
        $page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil ditambahkan.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'created_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        $page->fill($request->except('is_active', 'created_at'));
        $page->is_active = $request->has('is_active');
        if ($request->filled('created_at')) {
            $page->created_at = \Carbon\Carbon::parse($request->created_at);
        }
        
        if ($request->title !== $page->getOriginal('title')) {
            $page->slug = Str::slug($request->title);
        }
        
        $page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dihapus.');
    }

    public function duplicate($id)
    {
        $page = Page::findOrFail($id);
        $newPage = $page->replicate();
        $newPage->title = $page->title . ' (Copy)';
        $newPage->slug = Str::slug($newPage->title) . '-' . time();
        $newPage->is_active = false;
        $newPage->save();

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diduplikat menjadi Draft.');
    }
}
