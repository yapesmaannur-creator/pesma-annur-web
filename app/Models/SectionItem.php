<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionItem extends Model
{
    protected $fillable = [
        'page_section_id',
        'title',
        'subtitle',
        'description',
        'content',
        'image',
        'icon',
        'url',
        'order',
        'is_active',
    ];

    public function pageSection()
    {
        return $this->belongsTo(PageSection::class);
    }
}
