<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'nullable|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'link'      => 'nullable|url|max:255',
            'link_type' => 'nullable|in:button,image',
            'order'     => 'nullable|integer',
            'image'     => 'required|image|max:3072',
            'is_active' => 'nullable|boolean',
        ]);

        $banner = new Banner($request->except('image', 'is_active', 'link_type'));
        $banner->is_active  = $request->has('is_active');
        $banner->link_type  = $request->input('link_type', 'button');

        if ($request->hasFile('image')) {
            $banner->image = $request->file('image')->store('banners', 'public');
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title'     => 'nullable|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'link'      => 'nullable|url|max:255',
            'link_type' => 'nullable|in:button,image',
            'order'     => 'required|integer',
            'image'     => 'nullable|image|max:3072',
            'is_active' => 'nullable|boolean',
        ]);

        $banner->fill($request->except('image', 'is_active', 'link_type'));
        $banner->is_active  = $request->has('is_active');
        $banner->link_type  = $request->input('link_type', 'button');

        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $banner->image = $request->file('image')->store('banners', 'public');
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil dihapus.');
    }
}
