<?php
header('Content-Type: text/plain; charset=utf-8');

$host = '127.0.0.1';
$dbName = 'db_annur_v2';
$dbUser = 'root';
$dbPass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    // Find the homepage
    $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = 'beranda' OR slug = '/'");
    $stmt->execute();
    $page = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$page) {
        die("Homepage 'beranda' not found in pages table.\n");
    }
    
    echo "Found Homepage: ID = " . $page['id'] . ", Title = " . $page['title'] . ", Slug = " . $page['slug'] . "\n\n";
    
    // Find active sections
    $stmt = $pdo->prepare("SELECT * FROM page_sections WHERE page_id = ? AND is_active = 1 ORDER BY `order` ASC");
    $stmt->execute([$page['id']]);
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Active sections configured for homepage:\n";
    foreach ($sections as $sec) {
        echo "ID: " . $sec['id'] . " | Type/View: " . $sec['type'] . " | Title: " . $sec['title'] . " | Order: " . $sec['order'] . "\n";
    }
    
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage() . "\n");
}
