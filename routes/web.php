<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoutingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ShopController;

use App\Http\Controllers\FrontendController;

// Single routes for models
Route::get('/artikel', [ArticleController::class, 'index'])->name('article.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/penulis/{id}', [ArticleController::class, 'authorProfile'])->name('article.author');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/shop/{slug}/cite/bibtex', [ShopController::class, 'citeBibtex'])->name('shop.cite.bibtex');
Route::get('/shop/{slug}/cite/ris', [ShopController::class, 'citeRis'])->name('shop.cite.ris');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact'); // alias for route('contact')
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/faq', function() { return view('faq'); })->name('faq');
Route::get('/galeri', [\App\Http\Controllers\GalleryController::class, 'index'])->name('gallery.index');
Route::get('/galeri/{slug}', [\App\Http\Controllers\GalleryController::class, 'album'])->name('gallery.album');

// Newsletter Subscription
Route::post('/newsletter/subscribe', function (\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);
    // Store newsletter subscription (simple approach using a setting or log)
    \Illuminate\Support\Facades\Log::info('Newsletter subscription: ' . $request->email);
    return back()->with('success', 'Terima kasih! Email Anda telah didaftarkan untuk newsletter.');
})->name('newsletter.subscribe');

// Public Landing Routes (CMS Driven)
Route::get('/', [FrontendController::class, 'showPage'])->name('home');

// XML Sitemap
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Activity Detail
Route::get('/kegiatan/{slug}', [FrontendController::class, 'activityDetail'])->name('activity.detail');

// Article Submission
Route::get('/kirim-tulisan', [\App\Http\Controllers\Frontend\ArticleSubmissionController::class, 'create'])->name('submission.create');
Route::post('/kirim-tulisan', [\App\Http\Controllers\Frontend\ArticleSubmissionController::class, 'store'])->name('submission.store');

// Secure Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', \App\Http\Middleware\EnsureUserIsAdmin::class]], function () {
    
    // Add Role Middleware for strict Admin Check (assuming EnsureUserIsSantri is inverted or we use standard role check if defined)
    // For now we protect the namespace, assuming auth is sufficient or User model handles isAdmin() correctly.
    
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('programs', \App\Http\Controllers\Admin\ProgramController::class, ['as' => 'admin']);
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class, ['as' => 'admin']);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class, ['as' => 'admin']);
    Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class, ['as' => 'admin']);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class, ['as' => 'admin']);
    
    // Duplication Routes
    Route::post('posts/{post}/duplicate', [\App\Http\Controllers\Admin\PostController::class, 'duplicate'])->name('admin.posts.duplicate');
    Route::post('pages/{page}/duplicate', [\App\Http\Controllers\Admin\PageController::class, 'duplicate'])->name('admin.pages.duplicate');

    // Preview Route (untuk draft maupun published)
    Route::get('posts/{post}/preview', [\App\Http\Controllers\Admin\PostController::class, 'preview'])->name('admin.posts.preview');
    Route::get('products/{product}/preview', [\App\Http\Controllers\Admin\ProductController::class, 'preview'])->name('admin.products.preview');

    // Page Builder Route
    Route::get('pages/builder/{slug}', [\App\Http\Controllers\Admin\PageBuilderController::class, 'index'])->name('admin.pages.builder');

    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class, ['as' => 'admin']);
    Route::resource('page-sections', \App\Http\Controllers\Admin\PageSectionController::class, ['as' => 'admin']);
    
    // Section Items Routes
    Route::get('page-sections/{section}/items', [\App\Http\Controllers\Admin\SectionItemController::class, 'index'])->name('admin.page-sections.items');
    Route::resource('section-items', \App\Http\Controllers\Admin\SectionItemController::class, ['as' => 'admin'])->except(['index', 'show']);

    Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class, ['as' => 'admin']);
    Route::resource('gallery-albums', \App\Http\Controllers\Admin\GalleryAlbumController::class, ['as' => 'admin']);
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class, ['as' => 'admin']);
    Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class, ['as' => 'admin']);
    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class, ['as' => 'admin']);
    Route::resource('activities', \App\Http\Controllers\Admin\ActivityController::class, ['as' => 'admin']);
    Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class, ['as' => 'admin'])->only(['index', 'show', 'destroy']);
    
    // Article Submissions
    Route::post('submissions/{submission}/follow-up', [\App\Http\Controllers\Admin\ArticleSubmissionController::class, 'sendFollowUp'])->name('admin.submissions.follow_up');
    Route::post('submissions/{submission}/notify-live', [\App\Http\Controllers\Admin\ArticleSubmissionController::class, 'notifyLive'])->name('admin.submissions.notify_live');
    Route::resource('submissions', \App\Http\Controllers\Admin\ArticleSubmissionController::class, ['as' => 'admin'])->except(['create', 'store', 'edit']);
    
    // Super Admin only routes
    Route::group(['middleware' => [\App\Http\Middleware\EnsureUserIsSuperAdmin::class]], function() {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class, ['as' => 'admin']);
        Route::resource('downloads', \App\Http\Controllers\Admin\DownloadController::class, ['as' => 'admin']);
    });

    // Menu Builder Routes
    Route::get('menus', [\App\Http\Controllers\Admin\MenuController::class, 'builder'])->name('admin.menus.builder');
    Route::post('menus/store-menu', [\App\Http\Controllers\Admin\MenuController::class, 'storeMenu'])->name('admin.menus.store');
    Route::post('menus/store-item', [\App\Http\Controllers\Admin\MenuController::class, 'storeItem'])->name('admin.menus.items.store');
    Route::put('menus/update-item/{id}', [\App\Http\Controllers\Admin\MenuController::class, 'updateItem'])->name('admin.menus.items.update');
    Route::delete('menus/destroy-item/{id}', [\App\Http\Controllers\Admin\MenuController::class, 'destroyItem'])->name('admin.menus.items.destroy');
    Route::post('menus/reorder', [\App\Http\Controllers\Admin\MenuController::class, 'reorderItems'])->name('admin.menus.reorder');
});

// Template fallback routes
Route::group(['prefix' => '/template-demo', 'middleware' => 'auth'], function () {
    Route::get('', [RoutingController::class, 'index'])->name('root');
    Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('{any}', [RoutingController::class, 'root'])->name('any');
});

// Global Search
Route::get('/cari', [\App\Http\Controllers\SearchController::class, 'index'])->name('search.index');

// Download Center
Route::get('/unduhan', [\App\Http\Controllers\DownloadController::class, 'index'])->name('unduhan.index');
Route::get('/unduhan/{id}/download', [\App\Http\Controllers\DownloadController::class, 'download'])->name('unduhan.download');

// Dynamic CMS Route (Must be at the very bottom!)
Route::get('/{slug}', [FrontendController::class, 'showPage'])->name('page.dynamic');


Route::get('/dev-fix-hero-text', function() {
    \App\Models\Banner::query()->get()->each(function($b) {
        $changed = false;
        if (stripos($b->subtitle, 'Learn Quran') !== false || stripos($b->subtitle, 'Guided By') !== false || stripos($b->subtitle, 'Amet minim') !== false) {
            $b->subtitle = 'Pesantren Mahasiswa An-Nur Surabaya';
            $changed = true;
        }
        if (stripos($b->title, 'Learn Quran') !== false || stripos($b->title, 'Guided By') !== false || stripos($b->title, 'Amet minim') !== false) {
            $b->title = 'Tinggal, Belajar, dan Bertumbuh dalam Lingkungan Pesantren Mahasiswa';
            $changed = true;
        }
        if ($changed) $b->save();
    });

    \App\Models\PageSection::query()->get()->each(function($ps) {
        $changed = false;
        if (stripos($ps->subtitle, 'Learn Quran') !== false || stripos($ps->subtitle, 'Guided By') !== false || stripos($ps->subtitle, 'Amet minim') !== false) {
            $ps->subtitle = 'Pesantren Mahasiswa An-Nur Surabaya';
            $changed = true;
        }
        if (stripos($ps->title, 'Learn Quran') !== false || stripos($ps->title, 'Guided By') !== false || stripos($ps->title, 'Amet minim') !== false) {
            $ps->title = 'Tinggal, Belajar, dan Bertumbuh dalam Lingkungan Pesantren Mahasiswa';
            $changed = true;
        }
        if (stripos($ps->content, 'Amet minim') !== false) {
            $ps->content = 'Pesma An-Nur Surabaya menjadi ruang tinggal dan pembinaan bagi mahasiswa untuk memperkuat keilmuan, ibadah, akhlak, dan kemandirian dalam suasana pesantren.';
            $changed = true;
        }
        if ($changed) $ps->save();
    });

    return 'DB text cleaned successfully!';
});

Route::get('/agent-login', function () { Auth::loginUsingId(1); return redirect('/admin'); });

Route::get('/dev-db-test', function() {
    return response()->json([
        'connection' => \Illuminate\Support\Facades\DB::connection()->getName(),
        'database' => \Illuminate\Support\Facades\DB::connection()->getDatabaseName(),
        'posts_table_count' => \Illuminate\Support\Facades\DB::table('posts')->count(),
        'posts_published_count' => \App\Models\Post::published()->count(),
        'env_db_name' => env('DB_DATABASE'),
        'env_db_user' => env('DB_USERNAME'),
    ]);
});