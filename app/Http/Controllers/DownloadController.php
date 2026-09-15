<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('category');

        $categories = Download::categories();

        return view('frontend.pages.unduhan', compact('downloads', 'categories'));
    }

    public function download($id)
    {
        $download = Download::where('is_active', true)->findOrFail($id);
        $download->increment('download_count');

        return Storage::disk('public')->download($download->file_path, $download->file_name);
    }
}
