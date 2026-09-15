<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::orderBy('order')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.downloads.index', compact('downloads'));
    }

    public function create()
    {
        $categories = Download::categories();
        return view('admin.downloads.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:20480', // max 20MB
            'category' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $file = $request->file('file');
        $path = $file->store('downloads', 'public');

        Download::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getClientOriginalExtension(),
            'category' => $request->category,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'File berhasil diupload.');
    }

    public function edit(Download $download)
    {
        $categories = Download::categories();
        return view('admin.downloads.edit', compact('download', 'categories'));
    }

    public function update(Request $request, Download $download)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:20480',
            'category' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if ($download->file_path) {
                Storage::disk('public')->delete($download->file_path);
            }
            $file = $request->file('file');
            $data['file_path'] = $file->store('downloads', 'public');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['file_type'] = $file->getClientOriginalExtension();
        }

        $download->update($data);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'File berhasil diperbarui.');
    }

    public function destroy(Download $download)
    {
        if ($download->file_path) {
            Storage::disk('public')->delete($download->file_path);
        }
        $download->delete();

        return redirect()->route('admin.downloads.index')
            ->with('success', 'File berhasil dihapus.');
    }
}
