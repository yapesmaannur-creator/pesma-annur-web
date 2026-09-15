<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('products')) {
            // Because the products table somehow didn't exist in a previous error log, let's create it if missing!
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->decimal('price', 15, 2)->nullable();
                $table->decimal('discount_price', 15, 2)->nullable();
                $table->string('sku')->nullable();
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->string('meta_keywords')->nullable();
                $table->string('external_link_wa')->nullable();
                $table->string('external_link_marketplace')->nullable();
                $table->string('help_text')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'authors')) {
                $table->json('authors')->nullable();
                $table->json('editors')->nullable();
                $table->string('edition')->nullable();
                $table->date('publication_date')->nullable();
                $table->string('publication_location')->nullable();
                $table->string('publisher_imprint')->nullable();
                $table->string('doi')->nullable();
                $table->integer('pages')->nullable();
                $table->string('isbn')->nullable();
                $table->string('subjects')->nullable();
                $table->string('preview_document_path')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'authors', 'editors', 'edition', 'publication_date',
                'publication_location', 'publisher_imprint', 'doi',
                'pages', 'isbn', 'subjects', 'preview_document_path'
            ]);
        });
    }
};
