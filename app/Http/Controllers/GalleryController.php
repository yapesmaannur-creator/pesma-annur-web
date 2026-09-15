<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Show albums grid (main gallery page).
     */
    public function index()
    {
        $albums = GalleryAlbum::where('is_active', true)
            ->withCount('galleries')
            ->latest()
            ->get();

        return view('gallery', compact('albums'));
    }

    /**
     * Show photos inside a specific album.
     */
    public function album($slug)
    {
        $album = GalleryAlbum::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $galleries = Gallery::where('gallery_album_id', $album->id)
            ->where('is_active', true)
            ->latest()
            ->paginate(20);

        return view('gallery-album', compact('album', 'galleries'));
    }
}
