<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_name',
        'author_email',
        'author_phone',
        'title',
        'content',
        'attachment_path',
        'status',
        'admin_notes',
    ];
}
