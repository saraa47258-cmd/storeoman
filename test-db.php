<?php
/**
 * صفحة اختبار الاتصال بقاعدة البيانات
 * Test Database Connection
 */

require_once 'config.php';

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار قاعدة البيانات - StoreOman</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 15px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        .status {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            border: 2px solid #bee5eb;
            margin-top: 20px;
        }
        .info-item {
            padding: 10px;
            margin: 5px 0;
            background: #f8f9fa;
            border-radius: 5px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: right;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #667eea;
            color: white;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .back-link:hover {
            background: #5568d3;
        }
        .db-type {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .db-type.pgsql {
            background: #336791;
            color: white;
        }
        .db-type.mysql {
            background: #00758f;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 اختبار قاعدة البيانات</h1>
        
        <?php
        $dbType = getDBType();
        echo '<div class="db-type ' . $dbType . '">نوع قاعدة البيانات: ' . strtoupper($dbType) . '</div>';
        
        // اختبار الاتصال
        if (testDBConnection()) {
            echo '<div class="status success">✅ الاتصال بقاعدة البيانات نجح!</div>';
            
            try {
                $pdo = getDBConnection();
                
                // عرض معلومات الاتصال
                echo '<div class="info">';
                echo '<h3>معلومات الاتصال:</h3>';
                echo '<div class="info-item"><strong>نوع قاعدة البيانات:</strong> ' . strtoupper($dbType) . '</div>';
                echo '<div class="info-item"><strong>اسم الخادم:</strong> ' . DB_HOST . '</div>';
                echo '<div class="info-item"><strong>اسم قاعدة البيانات:</strong> ' . DB_NAME . '</div>';
                echo '<div class="info-item"><strong>اسم المستخدم:</strong> ' . DB_USER . '</div>';
                echo '<div class="info-item"><strong>المنفذ:</strong> ' . (defined('DB_PORT') ? DB_PORT : 'افتراضي') . '</div>';
                echo '</div>';
                
                // جلب المنتجات
                $stmt = $pdo->query("SELECT * FROM products LIMIT 10");
                $products = $stmt->fetchAll();
                
                if (count($products) > 0) {
                    echo '<h3 style="margin-top: 20px;">المنتجات في قاعدة البيانات:</h3>';
                    echo '<table>';
                    echo '<tr><th>ID</th><th>الاسم</th><th>السعر</th><th>الفئة</th><th>المخزون</th></tr>';
                    foreach ($products as $product) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($product['id']) . '</td>';
                        echo '<td>' . htmlspecialchars($product['name']) . '</td>';
                        echo '<td>' . htmlspecialchars($product['price']) . ' ر.ع</td>';
                        echo '<td>' . htmlspecialchars($product['category']) . '</td>';
                        echo '<td>' . htmlspecialchars($product['stock']) . '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo '<div class="info" style="margin-top: 20px;">لا توجد منتجات في قاعدة البيانات بعد.</div>';
                }
                
                // عرض عدد الجداول
                if ($dbType === 'pgsql') {
                    $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
                } else {
                    $stmt = $pdo->query("SHOW TABLES");
                }
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                echo '<div class="info" style="margin-top: 20px;">';
                echo '<strong>عدد الجداول:</strong> ' . count($tables);
                echo '<br><strong>أسماء الجداول:</strong> ' . implode(', ', $tables);
                echo '</div>';
                
            } catch (PDOException $e) {
                echo '<div class="status error">خطأ في الاستعلام: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
        } else {
            echo '<div class="status error">❌ فشل الاتصال بقاعدة البيانات!</div>';
            echo '<div class="info">';
            echo '<h3>تحقق من:</h3>';
            echo '<ul style="text-align: right; padding-right: 20px;">';
            echo '<li>أن حاوية PostgreSQL تعمل: <code>docker ps</code></li>';
            echo '<li>أن المشروع مربوط مع network الخاص بـ postgres-docker</li>';
            echo '<li>إعدادات الاتصال في ملف config.php</li>';
            echo '<li>إعدادات PostgreSQL في ملف .env أو docker-compose.yml</li>';
            echo '</ul>';
            echo '</div>';
        }
        ?>
        
        <a href="index.html" class="back-link">← العودة للصفحة الرئيسية</a>
    </div>
</body>
</html>
