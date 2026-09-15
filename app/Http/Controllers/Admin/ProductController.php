<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Traits\OptimizeWebp;

class ProductController extends Controller
{
    use OptimizeWebp;

    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = Product::query();
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('category_id', 'like', "%{$search}%");
        }
        $products = $query->orderByDesc('id')->paginate(10)->appends(request()->query());
        return view('admin.products.index', compact('products', 'search'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'nullable|numeric|min:0', // Made price nullable since books might not be sold directly
            'help_text' => 'nullable|string',
            'preview_document_path' => 'nullable|file|mimes:pdf|max:10240',
            'edition' => 'nullable|string',
            'publication_date' => 'nullable|date',
            'publication_location' => 'nullable|string',
            'publisher_imprint' => 'nullable|string',
            'doi' => 'nullable|string',
            'pages' => 'nullable|integer|min:1',
            'isbn' => 'nullable|string',
            'subjects' => 'nullable|string',
            'authors' => 'nullable|string',
            'editors' => 'nullable|string',
            'translators' => 'nullable|string',
        ]);

        $data = $request->except(['image', 'preview_document_path']);
        
        if ($request->filled('authors')) {
            $authors_arr = array_filter(array_map('trim', explode(',', $request->authors)));
            $data['authors'] = empty($authors_arr) ? null : array_values($authors_arr);
        } else {
            $data['authors'] = null;
        }

        if ($request->filled('editors')) {
            $editors_arr = array_filter(array_map('trim', explode(',', $request->editors)));
            $data['editors'] = empty($editors_arr) ? null : array_values($editors_arr);
        } else {
            $data['editors'] = null;
        }

        if ($request->filled('translators')) {
            $translators_arr = array_filter(array_map('trim', explode(',', $request->translators)));
            $data['translators'] = empty($translators_arr) ? null : array_values($translators_arr);
        } else {
            $data['translators'] = null;
        }

        $data['slug'] = Str::slug($request->name);

        // Ensure unique slug
        $originalSlug = $data['slug'];
        $count = 1;
        while (Product::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $count++;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->convertToWebp($request->file('image'), 'products');
        }

        if ($request->hasFile('preview_document_path')) {
            $data['preview_document_path'] = $request->file('preview_document_path')->store('books/previews', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'help_text' => 'nullable|string',
            'preview_document_path' => 'nullable|file|mimes:pdf|max:10240',
            'edition' => 'nullable|string',
            'publication_date' => 'nullable|date',
            'publication_location' => 'nullable|string',
            'publisher_imprint' => 'nullable|string',
            'doi' => 'nullable|string',
            'pages' => 'nullable|integer|min:1',
            'isbn' => 'nullable|string',
            'subjects' => 'nullable|string',
            'authors' => 'nullable|string',
            'editors' => 'nullable|string',
            'translators' => 'nullable|string',
        ]);

        $data = $request->except(['image', 'preview_document_path']);

        if ($request->filled('authors')) {
            $authors_arr = array_filter(array_map('trim', explode(',', $request->authors)));
            $data['authors'] = empty($authors_arr) ? null : array_values($authors_arr);
        } else {
            $data['authors'] = null;
        }

        if ($request->filled('editors')) {
            $editors_arr = array_filter(array_map('trim', explode(',', $request->editors)));
            $data['editors'] = empty($editors_arr) ? null : array_values($editors_arr);
        } else {
            $data['editors'] = null;
        }

        if ($request->filled('translators')) {
            $translators_arr = array_filter(array_map('trim', explode(',', $request->translators)));
            $data['translators'] = empty($translators_arr) ? null : array_values($translators_arr);
        } else {
            $data['translators'] = null;
        }

        if ($request->name !== $product->name) {
            $data['slug'] = Str::slug($request->name);
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $this->convertToWebp($request->file('image'), 'products');
        }

        if ($request->hasFile('preview_document_path')) {
            if ($product->preview_document_path) {
                Storage::disk('public')->delete($product->preview_document_path);
            }
            $data['preview_document_path'] = $request->file('preview_document_path')->store('books/previews', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function preview(Product $product)
    {
        // Preview admin: bisa lihat produk apapun, aktif maupun non-aktif
        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->latest()
            ->limit(4)
            ->get();

        $isPreview = true;

        return view('shop.show', compact('product', 'relatedProducts', 'isPreview'));
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        if ($product->preview_document_path) {
            Storage::disk('public')->delete($product->preview_document_path);
        }
        $product->delete();

        return back()->with('success', 'Buku berhasil dihapus.');
    }
}
