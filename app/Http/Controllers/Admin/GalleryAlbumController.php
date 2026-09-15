<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryAlbumController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::withCount('galleries')->latest()->paginate(10);
        return view('admin.gallery_albums.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.gallery_albums.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $album = new GalleryAlbum($request->except('cover_image', 'is_active'));
        $album->slug = Str::slug($request->title);
        $album->is_active = $request->has('is_active');

        if ($request->hasFile('cover_image')) {
            $album->cover_image = $request->file('cover_image')->store('albums', 'public');
        }

        $album->save();

        return redirect()->route('admin.gallery-albums.index')->with('success', 'Album Galeri berhasil ditambahkan.');
    }

    public function edit(GalleryAlbum $galleryAlbum)
    {
        return view('admin.gallery_albums.edit', compact('galleryAlbum'));
    }

    public function update(Request $request, GalleryAlbum $galleryAlbum)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $galleryAlbum->fill($request->except('cover_image', 'is_active'));
        $galleryAlbum->is_active = $request->has('is_active');
        
        if ($request->title !== $galleryAlbum->getOriginal('title')) {
            $galleryAlbum->slug = Str::slug($request->title);
        }

        if ($request->hasFile('cover_image')) {
            $galleryAlbum->cover_image = $request->file('cover_image')->store('albums', 'public');
        }

        $galleryAlbum->save();

        return redirect()->route('admin.gallery-albums.index')->with('success', 'Album Galeri berhasil diperbarui.');
    }

    public function destroy(GalleryAlbum $galleryAlbum)
    {
        $galleryAlbum->delete();
        return redirect()->route('admin.gallery-albums.index')->with('success', 'Album Galeri berhasil dihapus.');
    }
}
