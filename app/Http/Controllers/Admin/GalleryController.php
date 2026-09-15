<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\OptimizeWebp;

class GalleryController extends Controller
{
    use OptimizeWebp;

    public function index()
    {
        $galleries = Gallery::with('album')->latest()->paginate(15);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        $albums = GalleryAlbum::where('is_active', true)->get();
        return view('admin.galleries.create', compact('albums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gallery_album_id' => 'required|exists:gallery_albums,id',
            'title' => 'nullable|string|max:255',
            'images' => 'required|array|min:1',
            'images.*' => 'image|max:5120',
            'is_active' => 'nullable|boolean',
        ]);

        $count = 0;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $gallery = new Gallery();
                $gallery->gallery_album_id = $request->gallery_album_id;
                $gallery->title = $request->title;
                $gallery->is_active = $request->has('is_active');
                $gallery->image = $this->convertToWebp($file, 'galleries');
                $gallery->save();
                $count++;
            }
        }

        return redirect()->route('admin.galleries.index')->with('success', "$count foto berhasil diunggah (otomatis dikonversi ke WebP).");
    }

    public function edit(Gallery $gallery)
    {
        $albums = GalleryAlbum::where('is_active', true)->get();
        return view('admin.galleries.edit', compact('gallery', 'albums'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'gallery_album_id' => 'required|exists:gallery_albums,id',
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'is_active' => 'nullable|boolean',
        ]);

        $gallery->gallery_album_id = $request->gallery_album_id;
        $gallery->title = $request->title;
        $gallery->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            $gallery->image = $this->convertToWebp($request->file('image'), 'galleries');
        }

        $gallery->save();

        return redirect()->route('admin.galleries.index')->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        // Delete the file from storage
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Foto galeri berhasil dihapus.');
    }
}
