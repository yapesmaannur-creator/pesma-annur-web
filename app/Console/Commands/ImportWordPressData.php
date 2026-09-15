<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ImportWordPressData extends Command
{
    protected $signature = 'app:import-wp';
    protected $description = 'Import WordPress Posts and Products from temp database';

    public function handle()
    {
        $this->info("Setting up database connection...");
        
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

        $this->info("Importing Users...");
        $wpUsers = $wpDb->table('users')->get();
        $userMap = []; // WP User ID => Laravel User ID

        foreach ($wpUsers as $wpUser) {
            $email = $wpUser->user_email ?: ($wpUser->user_login . rand(1, 9999) . '@example.com');
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => rtrim($wpUser->display_name ?: $wpUser->user_login),
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'admin', // assigning a generic role, user can edit
                ]
            );
            $userMap[$wpUser->ID] = $user->id;
        }

        $this->info("Importing Categories...");
        $wpCategories = $wpDb->table('term_taxonomy')
            ->join('terms', 'term_taxonomy.term_id', '=', 'terms.term_id')
            ->where('taxonomy', 'category')
            ->get();
            
        $catMap = []; // WP Term ID => Laravel Category ID
        
        foreach ($wpCategories as $wpCat) {
            $slug = $wpCat->slug;
            if (empty($slug)) $slug = Str::slug($wpCat->name);
            
            $cat = Category::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => rtrim($wpCat->name),
                    'description' => $wpCat->description ?: null,
                ]
            );
            $catMap[$wpCat->term_id] = $cat->id;
        }

        $this->info("Importing Posts...");
        $wpPosts = $wpDb->table('posts')
            ->where('post_type', 'post')
            ->where('post_status', 'publish')
            ->get();

        $postCount = 0;
        foreach ($wpPosts as $wpPost) {
            // Find category
            $wpPostTerms = $wpDb->table('term_relationships')
                ->join('term_taxonomy', 'term_relationships.term_taxonomy_id', '=', 'term_taxonomy.term_taxonomy_id')
                ->where('term_relationships.object_id', $wpPost->ID)
                ->where('term_taxonomy.taxonomy', 'category')
                ->first();
                
            $categoryId = null;
            if ($wpPostTerms && isset($catMap[$wpPostTerms->term_id])) {
                $categoryId = $catMap[$wpPostTerms->term_id];
            }

            // Excerpt
            $excerpt = $wpPost->post_excerpt;
            if (empty($excerpt)) {
                $excerpt = Str::limit(strip_tags($wpPost->post_content), 150);
            }
            if (empty($excerpt)) {
                $excerpt = "-";
            }

            $slug = $wpPost->post_name;
            if (empty($slug)) {
                $slug = Str::slug($wpPost->post_title);
            }

            // Ensure unique slug
            $originalSlug = $slug;
            $counter = 1;
            while(Post::where('slug', $slug)->exists() && Post::where('slug', $slug)->value('title') !== $wpPost->post_title) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $userMap[$wpPost->post_author] ?? User::first()->id,
                    'category_id' => $categoryId,
                    'title' => rtrim($wpPost->post_title),
                    'excerpt' => rtrim($excerpt),
                    'body_content' => $wpPost->post_content,
                    'image_path' => null, // Excluded as user requested
                    'published_at' => $wpPost->post_date !== '0000-00-00 00:00:00' ? $wpPost->post_date : now(),
                ]
            );
            $postCount++;
        }
        $this->info("Imported {$postCount} posts.");

        $this->info("Importing Products...");
        $wpProducts = $wpDb->table('posts')
            ->where('post_type', 'product')
            ->where('post_status', 'publish')
            ->get();

        $productCount = 0;
        foreach ($wpProducts as $wpProd) {
            
            // Get postmeta for prices, sku etc.
            $metas = $wpDb->table('postmeta')
                ->where('post_id', $wpProd->ID)
                ->pluck('meta_value', 'meta_key')->toArray();
            
            $price = isset($metas['_regular_price']) && is_numeric($metas['_regular_price']) ? $metas['_regular_price'] : 0;
            if (empty($price) && isset($metas['_price']) && is_numeric($metas['_price'])) {
                $price = $metas['_price'];
            }
            
            $sale_price = isset($metas['_sale_price']) && is_numeric($metas['_sale_price']) ? $metas['_sale_price'] : null;
            if ($sale_price === "") $sale_price = null;
            
            $slug = $wpProd->post_name;
            if (empty($slug)) {
                $slug = Str::slug($wpProd->post_title);
            }

            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => rtrim($wpProd->post_title),
                    'description' => $wpProd->post_content,
                    'price' => $price,
                    'discount_price' => $sale_price,
                    'sku' => $metas['_sku'] ?? null,
                    'image' => null, // Excluded
                    'is_active' => true,
                    // If authors or isbn fields exist in postmeta, they will be here. Let's just catch basic meta keywords.
                    'meta_title' => $metas['_yoast_wpseo_title'] ?? null,
                    'meta_description' => $metas['_yoast_wpseo_metadesc'] ?? null,
                ]
            );
            $productCount++;
        }
        $this->info("Imported {$productCount} products.");

        $this->info("Migration completed successfully!");
    }
}
