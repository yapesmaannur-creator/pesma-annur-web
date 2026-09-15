<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\DB;

$tables = ['page_sections', 'banners', 'settings', 'pages', 'section_items', 'posts'];
$results = [];

foreach ($tables as $table) {
    if (\Illuminate\Support\Facades\Schema::hasTable($table)) {
        $rows = DB::table($table)->get();
        foreach ($rows as $row) {
            $json = json_encode($row);
            if (stripos($json, 'Learn Quran') !== false || stripos($json, 'Guided By') !== false || stripos($json, 'Amet minim') !== false) {
                $results[] = [
                    'table' => $table,
                    'row' => $row
                ];
            }
        }
    }
}

header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT);
unlink(__FILE__);
