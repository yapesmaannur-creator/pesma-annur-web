<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount(['posts' => function($q) {
            $q->published();
        }])->orderBy('name')->get();

        $query = Post::with(['user', 'category'])
                     ->published()
                     ->latest('published_at');

        // Filter by category
        $activeCategory = null;
        if ($request->has('category') && $request->category) {
            $activeCategory = Category::where('slug', $request->category)->first();
            if ($activeCategory) {
                $query->where('category_id', $activeCategory->id);
            }
        }

        $posts = $query->paginate(9)->withQueryString();

        return view('articles.index', compact('posts', 'categories', 'activeCategory'));
    }

    public function show($slug)
    {
        $article = Post::with(['user', 'category'])
                       ->where('slug', $slug)
                       ->published()
                       ->firstOrFail();

        // Previous & Next articles
        $prevArticle = Post::published()
            ->where('published_at', '<', $article->published_at)
            ->orderBy('published_at', 'desc')
            ->first();

        $nextArticle = Post::published()
            ->where('published_at', '>', $article->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        // Related articles (same category, exclude current)
        $relatedArticles = Post::published()
            ->where('id', '!=', $article->id)
            ->when($article->category_id, function($q) use ($article) {
                $q->where('category_id', $article->category_id);
            })
            ->limit(3)
            ->latest('published_at')
            ->get();

        return view('articles.show', compact('article', 'prevArticle', 'nextArticle', 'relatedArticles'));
    }

    public function authorProfile($id)
    {
        $author = \App\Models\User::findOrFail($id);
        
        $posts = Post::with(['category'])
                     ->where('user_id', $id)
                     ->published()
                     ->latest('published_at')
                     ->paginate(9);

        // Fetch user metadata. Provide a fallback only if it's completely empty.
        $bio = clone $author; 
        if (empty($bio->bio)) {
            $bio->bio = 'Belum ada biografi yang ditambahkan.';
        }
        if (empty($bio->role)) {
            $bio->role = 'Penulis / Pengajar';
        }

        return view('articles.author', compact('author', 'posts', 'bio'));
    }
}
