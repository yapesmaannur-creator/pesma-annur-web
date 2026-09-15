<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Traits\OptimizeWebp;

class PageSectionController extends Controller
{
    use OptimizeWebp;
    public function index()
    {
        $pageSections = PageSection::with('page')->latest()->paginate(10);
        return view('admin.page_sections.index', compact('pageSections'));
    }

    public function create(Request $request)
    {
        $pages = Page::where('is_active', true)->get();
        $selectedPageId = $request->query('page_id');
        return view('admin.page_sections.create', compact('pages', 'selectedPageId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_id' => 'required|exists:pages,id',
            'section_name' => 'required|string|max:255',
            'type' => 'required|string|max:80',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'image2' => 'nullable|image|max:2048',
            'image3' => 'nullable|image|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $section = new PageSection($request->except('image', 'image2', 'image3', 'is_active'));
        $section->is_active = $request->has('is_active');
        $section->order = $request->input('order', 0);
        
        if ($request->hasFile('image')) {
            $section->image = $this->convertToWebp($request->file('image'), 'page_sections');
        }
        if ($request->hasFile('image2')) {
            $section->image2 = $this->convertToWebp($request->file('image2'), 'page_sections');
        }
        if ($request->hasFile('image3')) {
            $section->image3 = $this->convertToWebp($request->file('image3'), 'page_sections');
        }

        $section->save();

        return redirect()->route('admin.pages.builder', $section->page->slug)->with('success', 'Section berhasil ditambahkan.');
    }

    public function edit(PageSection $pageSection)
    {
        $pages = Page::where('is_active', true)->get();
        return view('admin.page_sections.edit', compact('pageSection', 'pages'));
    }

    public function update(Request $request, PageSection $pageSection)
    {
        $request->validate([
            'page_id' => 'required|exists:pages,id',
            'section_name' => 'required|string|max:255',
            'type' => 'required|string|max:80',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'image2' => 'nullable|image|max:2048',
            'image3' => 'nullable|image|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $pageSection->fill($request->except('image', 'image2', 'image3', 'is_active'));
        $pageSection->is_active = $request->has('is_active');
        $pageSection->order = $request->input('order', 0);
        
        if ($request->has('delete_image')) {
            if ($pageSection->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($pageSection->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pageSection->image);
            }
            $pageSection->image = null;
        }
        if ($request->has('delete_image2')) {
            if ($pageSection->image2 && \Illuminate\Support\Facades\Storage::disk('public')->exists($pageSection->image2)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pageSection->image2);
            }
            $pageSection->image2 = null;
        }
        if ($request->has('delete_image3')) {
            if ($pageSection->image3 && \Illuminate\Support\Facades\Storage::disk('public')->exists($pageSection->image3)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pageSection->image3);
            }
            $pageSection->image3 = null;
        }

        if ($request->hasFile('image')) {
            $pageSection->image = $this->convertToWebp($request->file('image'), 'page_sections');
        }
        if ($request->hasFile('image2')) {
            $pageSection->image2 = $this->convertToWebp($request->file('image2'), 'page_sections');
        }
        if ($request->hasFile('image3')) {
            $pageSection->image3 = $this->convertToWebp($request->file('image3'), 'page_sections');
        }

        $pageSection->save();

        return redirect()->route('admin.pages.builder', $pageSection->page->slug)->with('success', 'Section berhasil diperbarui.');
    }

    public function destroy(PageSection $pageSection)
    {
        $slug = $pageSection->page->slug;
        $pageSection->delete();
        return redirect()->route('admin.pages.builder', $slug)->with('success', 'Section berhasil dihapus.');
    }
}
