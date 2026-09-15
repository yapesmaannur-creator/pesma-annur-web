<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait OptimizeWebp
{
    /**
     * Convert an uploaded image to WebP format for storage optimization.
     *
     * @param \Illuminate\Http\UploadedFile $file The uploaded file instance
     * @param string $directory The target storage directory (e.g. 'posts', 'galleries')
     * @param int $quality WebP compression quality (0-100)
     * @return string The relative path of the stored file
     */
    protected function convertToWebp($file, string $directory = 'uploads', int $quality = 82): string
    {
        $filename = trim($directory, '/') . '/' . Str::uuid() . '.webp';
        $fullPath = storage_path('app/public/' . $filename);

        // Ensure directory exists
        if (!is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        $mime = $file->getMimeType();
        $source = null;

        switch ($mime) {
            case 'image/jpeg':
                $source = @imagecreatefromjpeg($file->getRealPath());
                break;
            case 'image/png':
                $source = @imagecreatefrompng($file->getRealPath());
                if ($source) {
                    // Preserve transparency
                    imagepalettetotruecolor($source);
                    imagealphablending($source, true);
                    imagesavealpha($source, true);
                }
                break;
            case 'image/webp':
                // Already WebP, just store directly
                $file->storeAs($directory, basename($filename), 'public');
                $this->syncToPublicStorage($filename);
                return $filename;
            case 'image/gif':
                $source = @imagecreatefromgif($file->getRealPath());
                break;
            default:
                // Fallback for unsupported images: store as-is
                return $file->store($directory, 'public');
        }

        if ($source) {
            // Resize if too large (max 1600px width for performance)
            $width = imagesx($source);
            $height = imagesy($source);
            $maxWidth = 1600;

            if ($width > $maxWidth) {
                $newHeight = intval($height * ($maxWidth / $width));
                $resized = imagecreatetruecolor($maxWidth, $newHeight);
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                imagecopyresampled($resized, $source, 0, 0, 0, 0, $maxWidth, $newHeight, $width, $height);
                imagedestroy($source);
                $source = $resized;
            }

            imagewebp($source, $fullPath, $quality); 
            imagedestroy($source);

            // Sync to public/storage if not a symlink
            $this->syncToPublicStorage($filename);
            
            return $filename;
        }

        // Ultimate fallback
        $stored = $file->store($directory, 'public');
        $this->syncToPublicStorage($stored);
        return $stored;
    }

    /**
     * Helper to sync saved storage file to public/storage directory if symlink is detached or missing.
     */
    protected function syncToPublicStorage(string $relativePath): void
    {
        $storagePath = storage_path('app/public/' . $relativePath);
        $publicStoragePath = public_path('storage/' . $relativePath);

        if (file_exists($storagePath)) {
            $publicDir = dirname($publicStoragePath);
            if (!is_dir($publicDir)) {
                @mkdir($publicDir, 0755, true);
            }
            if (!file_exists($publicStoragePath) || filemtime($storagePath) > filemtime($publicStoragePath)) {
                @copy($storagePath, $publicStoragePath);
            }
        }
    }
}
