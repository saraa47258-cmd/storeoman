<?php
/**
 * API لجلب المنتجات من قاعدة البيانات
 * Products API Endpoint
 */

header('Content-Type: application/json; charset=utf-8');
require_once '../config.php';

try {
    $pdo = getDBConnection();
    
    // جلب جميع المنتجات
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll();
    
    // إرجاع النتيجة كـ JSON
    echo json_encode([
        'success' => true,
        'count' => count($products),
        'products' => $products
    ], JSON_UNESCAPED_UNICODE);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'خطأ في جلب المنتجات: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
