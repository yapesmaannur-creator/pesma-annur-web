<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'category',
        'download_count',
        'is_active',
        'order',
    ];

    /**
     * Get human-readable file size
     */
    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Get file icon class based on file type
     */
    public function getFileIconAttribute(): string
    {
        return match (strtolower($this->file_type ?? '')) {
            'pdf' => 'feather-file-text',
            'doc', 'docx' => 'feather-file-text',
            'xls', 'xlsx' => 'feather-grid',
            'ppt', 'pptx' => 'feather-monitor',
            'zip', 'rar' => 'feather-archive',
            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'feather-image',
            default => 'feather-file',
        };
    }

    public static function categories(): array
    {
        return [
            'umum' => 'Umum',
            'brosur' => 'Brosur',
            'formulir' => 'Formulir',
            'panduan' => 'Panduan',
            'materi' => 'Materi Kajian',
            'laporan' => 'Laporan',
        ];
    }
}
