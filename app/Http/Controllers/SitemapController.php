<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Activity;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $pages = Page::where('is_active', true)->orderBy('updated_at', 'desc')->get();
        $posts = Post::whereNotNull('published_at')->where('published_at', '<=', now())->orderBy('updated_at', 'desc')->get();
        $activities = Activity::where('is_active', true)->orderBy('updated_at', 'desc')->get();
        $products = Product::where('is_active', true)->orderBy('updated_at', 'desc')->get();

        $content = view('sitemap', compact('pages', 'posts', 'activities', 'products'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
