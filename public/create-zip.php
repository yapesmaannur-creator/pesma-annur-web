<?php
$zip = new ZipArchive();
$zipFile = __DIR__ . '/perbaikan_artikel_dan_banner.zip';

if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    $files = [
        'app/Http/Controllers/Admin/PostController.php' => __DIR__ . '/../app/Http/Controllers/Admin/PostController.php',
        'app/Http/Controllers/Admin/ArticleSubmissionController.php' => __DIR__ . '/../app/Http/Controllers/Admin/ArticleSubmissionController.php',
        'resources/views/admin/posts/create.blade.php' => __DIR__ . '/../resources/views/admin/posts/create.blade.php',
        'resources/views/admin/posts/index.blade.php' => __DIR__ . '/../resources/views/admin/posts/index.blade.php',
        'resources/views/admin/submissions/index.blade.php' => __DIR__ . '/../resources/views/admin/submissions/index.blade.php',
        'resources/views/frontend/sections/hero.blade.php' => __DIR__ . '/../resources/views/frontend/sections/hero.blade.php',
        'resources/views/frontend/pages/dynamic.blade.php' => __DIR__ . '/../resources/views/frontend/pages/dynamic.blade.php',
        'routes/web.php' => __DIR__ . '/../routes/web.php',
        'routes/api.php' => __DIR__ . '/../routes/api.php',
        'app/Http/Controllers/SitemapController.php' => __DIR__ . '/../app/Http/Controllers/SitemapController.php',
        'resources/views/sitemap.blade.php' => __DIR__ . '/../resources/views/sitemap.blade.php',
    ];

    foreach ($files as $localName => $filePath) {
        if (file_exists($filePath)) {
            $zip->addFile($filePath, $localName);
        } else {
            echo "File not found: $filePath<br>";
        }
    }
    $zip->close();
    
    // Also try copying to User's Downloads folder
    $userDownloadsDir = 'C:/Users/Ahmad Nabilul Maram/Downloads';
    if (is_dir($userDownloadsDir)) {
        copy($zipFile, $userDownloadsDir . '/perbaikan_artikel_dan_banner.zip');
        echo "Zip copied to: " . $userDownloadsDir . "/perbaikan_artikel_dan_banner.zip<br>";
    }
    echo "Zip created successfully in public folder: /perbaikan_artikel_dan_banner.zip<br>";
} else {
    echo "Failed to create zip file<br>";
}
