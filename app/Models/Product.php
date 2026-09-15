<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->sku)) {
                $lastProduct = static::orderByDesc('id')->first();
                $nextId = $lastProduct ? $lastProduct->id + 1 : 1;
                $product->sku = 'ANNUR-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }
        });
    }
    protected $fillable = [
        'name', 'slug', 'description', 'image',
        'price', 'discount_price', 'sku',
        'meta_title', 'meta_description', 'meta_keywords',
        'external_link_wa', 'external_link_marketplace',
        'help_text', 'is_active',
        // Book Attributes
        'authors', 'editors', 'translators', 'edition', 'publication_date',
        'publication_location', 'publisher_imprint', 'doi',
        'pages', 'isbn', 'subjects', 'preview_document_path'
    ];

    protected $casts = [
        'authors' => 'array',
        'editors' => 'array',
        'translators' => 'array',
        'publication_date' => 'date',
        'is_active' => 'boolean',
    ];
}
