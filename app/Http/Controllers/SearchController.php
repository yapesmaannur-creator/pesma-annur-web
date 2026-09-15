<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use App\Models\Program;
use App\Models\Faq;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');

        if (empty($query) || strlen($query) < 2) {
            return view('frontend.pages.search', [
                'query' => $query,
                'results' => collect(),
                'totalResults' => 0,
            ]);
        }

        $searchTerm = '%' . $query . '%';

        // Search articles
        $articles = Post::whereNotNull('published_at')
            ->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('body_content', 'like', $searchTerm)
                  ->orWhere('excerpt', 'like', $searchTerm);
            })
            ->select('id', 'title', 'slug', 'excerpt', 'image_path as image', 'published_at')
            ->take(10)
            ->get()
            ->map(function($item) {
                $item->type = 'Artikel';
                $item->url = route('article.show', $item->slug);
                return $item;
            });

        // Search products
        $products = Product::where('is_active', true)
            ->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
            })
            ->select('id', 'name as title', 'slug', 'description as excerpt', 'image', 'price')
            ->take(10)
            ->get()
            ->map(function($item) {
                $item->type = 'Produk';
                $item->url = route('shop.show', $item->slug);
                return $item;
            });

        // Search programs
        $programs = Program::where('is_active', true)
            ->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
            })
            ->select('id', 'title', 'slug', 'description as excerpt', 'image')
            ->take(10)
            ->get()
            ->map(function($item) {
                $item->type = 'Program';
                $item->url = url('/program');
                return $item;
            });

        // Search FAQs
        $faqs = \App\Models\Faq::where('is_active', true)
            ->where(function($q) use ($searchTerm) {
                $q->where('question', 'like', $searchTerm)
                  ->orWhere('answer', 'like', $searchTerm);
            })
            ->select('id', 'question as title', 'answer as excerpt')
            ->take(10)
            ->get()
            ->map(function($item) {
                $item->type = 'FAQ';
                $item->url = url('/faq');
                return $item;
            });

        // Search Downloads
        $downloads = \App\Models\Download::where('is_active', true)
            ->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
            })
            ->select('id', 'title', 'file_name as slug', 'description as excerpt')
            ->take(10)
            ->get()
            ->map(function($item) {
                $item->type = 'Unduhan';
                $item->url = route('unduhan.index'); // We will build this page
                return $item;
            });


        // Merge all results
        $results = collect()
            ->merge($articles)
            ->merge($products)
            ->merge($programs)
            ->merge($faqs)
            ->merge($downloads);

        $totalResults = $results->count();

        return view('frontend.pages.search', compact('query', 'results', 'totalResults'));
    }
}
