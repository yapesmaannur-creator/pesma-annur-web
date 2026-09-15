<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use App\Models\Program;
use App\Models\User;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\ArticleSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_programs' => Program::count(),
            'active_programs' => Program::where('is_active', true)->count(),
            'total_posts' => Post::count(),
            'total_products' => Product::count(),
            'total_contacts' => Contact::count(),
            'total_galleries' => Gallery::count(),
            'total_submissions' => class_exists(ArticleSubmission::class) ? ArticleSubmission::count() : 0,
        ];
        
        // Sorted by published_at descending so imported WordPress articles show correctly
        $recent_posts = Post::with('user')
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->take(5)
            ->get();
        $recent_contacts = Contact::orderBy('created_at', 'desc')->take(5)->get();

        // Chart data: Articles per month (last 6 months) — using published_at
        $months = collect();
        $articleCounts = collect();
        $contactCounts = collect();

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push($date->translatedFormat('M Y'));

            $articleCounts->push(
                Post::whereNotNull('published_at')
                    ->whereYear('published_at', $date->year)
                    ->whereMonth('published_at', $date->month)
                    ->count()
            );

            $contactCounts->push(
                Contact::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            );
        }

        $chartData = [
            'months' => $months,
            'articles' => $articleCounts,
            'contacts' => $contactCounts,
        ];

        return view('admin.dashboard', compact('stats', 'recent_posts', 'recent_contacts', 'chartData'));
    }
}
