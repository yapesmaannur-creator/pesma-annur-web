<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\OptimizeWebp;

class PostController extends Controller
{
    use OptimizeWebp;

    public function index(Request $request)
    {
        $query = Post::with(['user', 'category']);
        
        $search = $request->get('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('body_content', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('status') && $request->status == 'draft') {
            $query->whereNull('published_at');
        } elseif ($request->has('status') && $request->status == 'published') {
            $query->whereNotNull('published_at');
        }

        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') {
            // Draft (published_at null) paling akhir, lalu urut dari terlama
            $query->orderByRaw('COALESCE(published_at, created_at) ASC');
        } else {
            // Default: terbaru berdasarkan published_at, draft di atas berdasarkan created_at
            $query->orderByRaw('COALESCE(published_at, created_at) DESC');
        }

        $posts = $query->paginate(15)->appends(request()->query());
        return view('admin.posts.index', compact('posts', 'search'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        return view('admin.posts.create', compact('categories', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'body_content' => 'required|string',
            'image_path' => 'nullable|image|max:2048',
            'image_caption' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'user_id' => 'nullable|exists:users,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);

        $post = new Post($request->except('image_path', 'is_published', 'excerpt', 'user_id'));
        $post->user_id = $request->input('user_id') ?: \Illuminate\Support\Facades\Auth::id();
        $post->excerpt = $request->input('excerpt') ?? '';
        
        // Generate automatic unique slug to prevent duplicate entry unique SQL constraints
        $slug = Str::slug($request->title);
        $count = Post::where('slug', 'LIKE', "{$slug}%")->count();
        $post->slug = $count > 0 ? "{$slug}-{$count}" : $slug;

        if ($request->hasFile('image_path')) {
            $post->image_path = $this->convertToWebp($request->file('image_path'), 'posts');
        }

        // Handle published_at and is_published
        if (!$request->has('is_published')) {
            $post->published_at = null;
        } else {
            if ($request->filled('published_at')) {
                $post->published_at = $request->published_at;
            } else {
                $post->published_at = now();
            }
        }

        $post->save();

        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories', 'users'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'body_content' => 'required|string',
            'image_path' => 'nullable|image|max:2048',
            'image_caption' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'user_id' => 'nullable|exists:users,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);

        // Explicitly set each field to ensure they save
        $post->title = $request->input('title');
        $post->excerpt = $request->input('excerpt') ?? '';
        $post->body_content = $request->input('body_content');
        $post->image_caption = $request->input('image_caption');
        $post->category_id = $request->input('category_id') ?: null;
        if ($request->filled('user_id')) {
            $post->user_id = $request->input('user_id');
        }
        $post->meta_title = $request->input('meta_title');
        $post->meta_description = $request->input('meta_description');
        $post->meta_keywords = $request->input('meta_keywords');

        // Update slug if title changed, ensuring it remains unique
        if ($request->input('title') !== $post->getOriginal('title')) {
            $slug = Str::slug($request->input('title'));
            $count = Post::where('slug', 'LIKE', "{$slug}%")->where('id', '!=', $post->id)->count();
            $post->slug = $count > 0 ? "{$slug}-{$count}" : $slug;
        }

        // Handle image upload
        if ($request->hasFile('image_path')) {
            $post->image_path = $this->convertToWebp($request->file('image_path'), 'posts');
        }

        // Handle published_at and is_published
        if (!$request->has('is_published')) {
            $post->published_at = null;
        } else {
            if ($request->filled('published_at')) {
                $post->published_at = $request->input('published_at');
            } else {
                // If published checkbox is checked but date is left empty, keep old date if exists, or default to now()
                $post->published_at = $post->published_at ?: now();
            }
        }

        \Illuminate\Support\Facades\Log::info('Post update', [
            'id' => $post->id,
            'category_id' => $post->category_id,
            'title' => $post->title,
            'dirty' => $post->getDirty(),
        ]);

        $post->save();

        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil dihapus.');
    }

    public function preview(Post $post)
    {
        // Load relasi yang dibutuhkan view artikel
        $post->load(['user', 'category']);

        // Related articles (published saja, bukan draft ini)
        $relatedArticles = Post::published()
            ->where('id', '!=', $post->id)
            ->when($post->category_id, function ($q) use ($post) {
                $q->where('category_id', $post->category_id);
            })
            ->limit(3)
            ->latest('published_at')
            ->get();

        $prevArticle = null;
        $nextArticle = null;
        $isPreview   = true; // flag untuk view

        return view('articles.show', compact('post', 'prevArticle', 'nextArticle', 'relatedArticles', 'isPreview'))
            ->with('article', $post); // 'article' adalah variabel yang dipakai di articles.show
    }

    public function duplicate(int $id)
    {
        $post = Post::findOrFail($id);
        $newPost = $post->replicate();
        $newPost->title = $post->title . ' (Copy)';
        $newPost->slug = Str::slug($newPost->title) . '-' . time();
        $newPost->published_at = null; // Save as Draft
        $newPost->save();

        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil diduplikat sebagai Draft.');
    }
}
