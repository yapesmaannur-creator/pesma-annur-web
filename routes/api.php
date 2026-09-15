<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Program;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/programs', function (Request $request) {
    $query = Program::where('is_active', true);
    
    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }
    
    return response()->json(['data' => $query->latest()->get()]);
})->name('api.programs.index');

// API to synchronize "Kabar Terbaru" (Latest News / Posts) with e-maktab
Route::get('/kabar-terbaru', function (Request $request) {
    $limit = $request->integer('limit', 10);
    if ($limit > 50) $limit = 50;

    $posts = \App\Models\Post::published()
        ->with(['category', 'user'])
        ->latest('published_at')
        ->paginate($limit);

    // Transform response data to make it extremely easy to consume on e-maktab
    $posts->getCollection()->transform(function ($post) {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'excerpt' => $post->excerpt,
            'body_content' => $post->body_content,
            'image_url' => $post->image_path ? asset('storage/' . $post->image_path) : asset('frontend/images/bg-image-12.jpg'),
            'category' => $post->category ? $post->category->name : null,
            'author' => $post->user ? $post->user->name : 'Admin',
            'published_at' => $post->published_at ? $post->published_at->toIso8601String() : null,
            'created_at' => $post->created_at->toIso8601String(),
        ];
    });

    return response()->json($posts);
})->name('api.kabar-terbaru');

