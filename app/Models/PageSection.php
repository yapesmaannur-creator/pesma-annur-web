<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'section_name',
        'type',
        'title',
        'subtitle',
        'content',
        'image',
        'image2',
        'image3',
        'button_text',
        'button_url',
        'order',
        'is_active',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function items()
    {
        return $this->hasMany(SectionItem::class)->orderBy('order');
    }
}
