<?php
/**
 * سكريبت إنشاء حساب الأدمن
 * Create Admin Account Script
 * 
 * ⚠️ احذف هذا الملف بعد إنشاء الحساب!
 */

require_once 'config.php';

try {
    $pdo = getDBConnection();
    
    // التحقق من وجود جدول users
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(100) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            full_name VARCHAR(255),
            phone VARCHAR(20),
            role VARCHAR(50) DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // التحقق من وجود الأدمن
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = 'admin'");
    $stmt->execute();
    $existing_admin = $stmt->fetch();
    
    if ($existing_admin) {
        echo "⚠️ حساب الأدمن موجود بالفعل!<br>";
        echo "اسم المستخدم: admin<br>";
        echo "كلمة المرور: admin123<br>";
        echo "<br><a href='login.php'>تسجيل الدخول</a>";
    } else {
        // إنشاء حساب الأدمن
        $username = 'admin';
        $password = 'admin123';
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("
            INSERT INTO users (username, email, password, full_name, role) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $username,
            'admin@storeoman.com',
            $hashed_password,
            'مدير النظام',
            'admin'
        ]);
        
        echo "✅ تم إنشاء حساب الأدمن بنجاح!<br><br>";
        echo "اسم المستخدم: <strong>admin</strong><br>";
        echo "كلمة المرور: <strong>admin123</strong><br><br>";
        echo "⚠️ <strong>احذف هذا الملف (create-admin.php) بعد تسجيل الدخول!</strong><br><br>";
        echo "<a href='login.php' style='padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;'>تسجيل الدخول</a>";
    }
    
} catch (PDOException $e) {
    echo "❌ خطأ: " . $e->getMessage();
}
