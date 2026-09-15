<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Str;

class DownloadWpImages extends Command
{
    protected $signature = 'app:download-wp-images';
    protected $description = 'Download featured images from WordPress site and update local posts/products';

    public function handle()
    {
        $this->info("Setting up WordPress database connection...");

        Config::set('database.connections.wp', [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'temp_wp_full',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => 'wp2r_',
            'strict' => false,
            'engine' => null,
        ]);

        $wpDb = DB::connection('wp');

        // Ensure storage directories exist
        Storage::disk('public')->makeDirectory('posts');
        Storage::disk('public')->makeDirectory('products');

        // ─── POSTS ───────────────────────────────────────────────
        $this->info("\n=== Downloading Post Featured Images ===");
        $wpPostImages = $wpDb->select("
            SELECT p.ID, p.post_title, p.post_name, att.guid as image_url
            FROM wp2r_posts p
            INNER JOIN wp2r_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_thumbnail_id'
            INNER JOIN wp2r_posts att ON pm.meta_value = att.ID
            WHERE p.post_type = 'post' AND p.post_status = 'publish'
            ORDER BY p.post_date DESC
        ");

        $postDownloaded = 0;
        $postSkipped = 0;
        $postFailed = 0;

        foreach ($wpPostImages as $wpPost) {
            $imageUrl = $wpPost->image_url;

            // Skip demo/template images (not from pesma-annur.net)
            if (strpos($imageUrl, 'pesma-annur.net') === false) {
                $this->line("  ⏭ SKIP (demo): {$wpPost->post_name}");
                $postSkipped++;
                continue;
            }

            // Find matching Laravel post by slug (try both encoded and decoded)
            $slugRaw = $wpPost->post_name;
            $slugDecoded = urldecode($slugRaw);
            $post = Post::where('slug', $slugRaw)->orWhere('slug', $slugDecoded)->first();
            if (!$post) {
                $this->warn("  ⚠ Post not found in Laravel: {$slugRaw}");
                $postFailed++;
                continue;
            }
            $slug = $post->slug;

            // Skip if already has an image
            if (!empty($post->image_path)) {
                $this->line("  ✓ Already has image: {$slug}");
                $postSkipped++;
                continue;
            }

            // Download the image
            $localPath = $this->downloadImage($imageUrl, 'posts');
            if ($localPath) {
                $post->image_path = $localPath;
                $post->save();
                $this->info("  ✅ Downloaded: {$slug} => {$localPath}");
                $postDownloaded++;
            } else {
                $this->error("  ❌ Failed to download: {$imageUrl}");
                $postFailed++;
            }
        }

        $this->info("\nPosts Summary: Downloaded={$postDownloaded}, Skipped={$postSkipped}, Failed={$postFailed}");

        // ─── PRODUCTS ────────────────────────────────────────────
        $this->info("\n=== Downloading Product Featured Images ===");
        $wpProdImages = $wpDb->select("
            SELECT p.ID, p.post_title, p.post_name, att.guid as image_url
            FROM wp2r_posts p
            INNER JOIN wp2r_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_thumbnail_id'
            INNER JOIN wp2r_posts att ON pm.meta_value = att.ID
            WHERE p.post_type = 'product' AND p.post_status = 'publish'
            ORDER BY p.post_date DESC
        ");

        $prodDownloaded = 0;
        $prodSkipped = 0;
        $prodFailed = 0;

        foreach ($wpProdImages as $wpProd) {
            $imageUrl = $wpProd->image_url;

            // Find matching Laravel product by slug (try both encoded and decoded)
            $slugRaw = $wpProd->post_name;
            $slugDecoded = urldecode($slugRaw);
            $product = Product::where('slug', $slugRaw)->orWhere('slug', $slugDecoded)->first();
            if (!$product) {
                $this->warn("  ⚠ Product not found in Laravel: {$slugRaw}");
                $prodFailed++;
                continue;
            }
            $slug = $product->slug;

            // Skip if already has an image
            if (!empty($product->image)) {
                $this->line("  ✓ Already has image: {$slug}");
                $prodSkipped++;
                continue;
            }

            // Download the image
            $localPath = $this->downloadImage($imageUrl, 'products');
            if ($localPath) {
                $product->image = $localPath;
                $product->save();
                $this->info("  ✅ Downloaded: {$slug} => {$localPath}");
                $prodDownloaded++;
            } else {
                $this->error("  ❌ Failed to download: {$imageUrl}");
                $prodFailed++;
            }
        }

        $this->info("\nProducts Summary: Downloaded={$prodDownloaded}, Skipped={$prodSkipped}, Failed={$prodFailed}");
        $this->info("\n✅ All done!");
    }

    /**
     * Download an image from URL and save to local storage.
     *
     * @param string $url
     * @param string $folder (e.g. 'posts' or 'products')
     * @return string|null The relative storage path, or null on failure
     */
    private function downloadImage(string $url, string $folder): ?string
    {
        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 30,
                    'user_agent' => 'Mozilla/5.0 (compatible; LaravelImporter/1.0)',
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);

            $imageData = @file_get_contents($url, false, $context);
            if ($imageData === false) {
                return null;
            }

            // Determine extension from URL
            $urlPath = parse_url($url, PHP_URL_PATH);
            $extension = pathinfo($urlPath, PATHINFO_EXTENSION) ?: 'jpg';

            // Generate a clean filename
            $filename = Str::random(20) . '.' . $extension;
            $storagePath = $folder . '/' . $filename;

            Storage::disk('public')->put($storagePath, $imageData);

            return $storagePath;
        } catch (\Exception $e) {
            $this->error("    Exception: " . $e->getMessage());
            return null;
        }
    }
}
