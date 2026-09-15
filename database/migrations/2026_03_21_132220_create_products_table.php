<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            
            // Pricing & Inventory
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('discount_price', 15, 2)->nullable();
            $table->string('sku')->nullable();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // External Links
            $table->string('external_link_wa')->nullable()->comment('Format: 62812xxx atau wa.me link');
            $table->string('external_link_marketplace')->nullable()->comment('Link Tokopedia/Shopee/dll');
            
            // Status
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
