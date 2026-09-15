<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch programs secara efisien
        $programs = Program::where('is_active', true)
                           ->take(6)
                           ->get();

        // Fetch post dengan Eager Loading relasi user (pencegahan N+1)
        // Memanfaatkan Scope `published()` bawaan Model Post
        $posts = Post::with('user')
                     ->published()
                     ->latest('published_at')
                     ->take(3)
                     ->get();
                     
        return view('welcome', compact('programs', 'posts'));
    }
}
