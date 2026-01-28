<?php
/**
 * لوحة تحكم الأدمن
 * Admin Dashboard
 */

session_start();

// التحقق من تسجيل الدخول
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once 'config.php';

// جلب إحصائيات
try {
    $pdo = getDBConnection();
    
    // عدد المنتجات
    $products_count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    
    // عدد المستخدمين
    $users_count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    
    // عدد الطلبات
    $orders_count = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    
    // آخر المنتجات
    $latest_products = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 5")->fetchAll();
    
    // آخر الطلبات
    $latest_orders = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5")->fetchAll();
    
} catch (PDOException $e) {
    $error = 'خطأ في الاتصال بقاعدة البيانات';
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الأدمن - StoreOman</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 1.8em;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .logout-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-right: 5px solid #667eea;
        }

        .stat-card h3 {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .stat-card .number {
            font-size: 2.5em;
            font-weight: bold;
            color: #667eea;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .section h2 {
            color: #667eea;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: right;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background: #f8f9fa;
            color: #667eea;
            font-weight: 600;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
        }

        .badge-success {
            background: #e8f5e9;
            color: #4caf50;
        }

        .badge-warning {
            background: #fff3e0;
            color: #ff9800;
        }

        .badge-danger {
            background: #ffebee;
            color: #f44336;
        }

        .welcome-msg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .welcome-msg h2 {
            color: white;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🛍️ StoreOman - لوحة التحكم</h1>
        <div class="header-actions">
            <span>مرحباً، <?php echo htmlspecialchars($_SESSION['admin_name']); ?></span>
            <a href="logout.php" class="logout-btn">تسجيل الخروج</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome-msg">
            <h2>مرحباً بك في لوحة التحكم</h2>
            <p>إدارة متجر StoreOman</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>عدد المنتجات</h3>
                <div class="number"><?php echo $products_count ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>عدد المستخدمين</h3>
                <div class="number"><?php echo $users_count ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>عدد الطلبات</h3>
                <div class="number"><?php echo $orders_count ?? 0; ?></div>
            </div>
        </div>

        <div class="section">
            <h2>آخر المنتجات</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>الاسم</th>
                        <th>السعر</th>
                        <th>الفئة</th>
                        <th>المخزون</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($latest_products)): ?>
                        <?php foreach ($latest_products as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['id']); ?></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['price']); ?> ر.ع</td>
                                <td><?php echo htmlspecialchars($product['category']); ?></td>
                                <td><?php echo htmlspecialchars($product['stock']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #999;">لا توجد منتجات</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>آخر الطلبات</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>المبلغ الإجمالي</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($latest_orders)): ?>
                        <?php foreach ($latest_orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['id']); ?></td>
                                <td><?php echo htmlspecialchars($order['total_amount']); ?> ر.ع</td>
                                <td>
                                    <span class="badge badge-<?php 
                                        echo $order['status'] === 'completed' ? 'success' : 
                                            ($order['status'] === 'pending' ? 'warning' : 'danger'); 
                                    ?>">
                                        <?php echo htmlspecialchars($order['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #999;">لا توجد طلبات</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
