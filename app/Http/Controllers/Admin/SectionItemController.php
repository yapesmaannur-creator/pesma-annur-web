<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use App\Models\SectionItem;
use Illuminate\Http\Request;

class SectionItemController extends Controller
{
    public function index($sectionId)
    {
        $pageSection = PageSection::with('items')->findOrFail($sectionId);
        return view('admin.section_items.index', compact('pageSection'));
    }

    public function create(Request $request)
    {
        $pageSection = PageSection::findOrFail($request->query('section_id'));
        return view('admin.section_items.create', compact('pageSection'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_section_id' => 'required|exists:page_sections,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'icon' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $item = new SectionItem($request->except('image', 'is_active'));
        $item->is_active = $request->has('is_active');
        $item->order = $request->input('order', 0);
        
        if ($request->hasFile('image')) {
            $item->image = $request->file('image')->store('section_items', 'public');
        }

        $item->save();

        return redirect()->route('admin.page-sections.items', $item->page_section_id)->with('success', 'Item berhasil ditambahkan.');
    }

    public function edit(SectionItem $sectionItem)
    {
        return view('admin.section_items.edit', compact('sectionItem'));
    }

    public function update(Request $request, SectionItem $sectionItem)
    {
        $request->validate([
            'page_section_id' => 'required|exists:page_sections,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'icon' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $sectionItem->fill($request->except('image', 'is_active'));
        $sectionItem->is_active = $request->has('is_active');
        $sectionItem->order = $request->input('order', 0);
        
        if ($request->hasFile('image')) {
            $sectionItem->image = $request->file('image')->store('section_items', 'public');
        }

        $sectionItem->save();

        return redirect()->route('admin.page-sections.items', $sectionItem->page_section_id)->with('success', 'Item berhasil diperbarui.');
    }

    public function destroy(SectionItem $sectionItem)
    {
        $sectionId = $sectionItem->page_section_id;
        $sectionItem->delete();
        return redirect()->route('admin.page-sections.items', $sectionId)->with('success', 'Item berhasil dihapus.');
    }
}
