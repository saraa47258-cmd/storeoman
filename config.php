<?php
/**
 * ملف إعدادات الاتصال بقاعدة البيانات
 * StoreOman Database Configuration
 * يدعم MySQL و PostgreSQL
 */

// نوع قاعدة البيانات: 'mysql' أو 'pgsql'
define('DB_TYPE', getenv('DB_TYPE') ?: 'pgsql');

// إعدادات قاعدة البيانات
if (DB_TYPE === 'pgsql') {
    // إعدادات PostgreSQL (لربط مع postgres-docker)
    define('DB_HOST', getenv('POSTGRES_HOST') ?: 'postgres_db');  // اسم حاوية PostgreSQL
    define('DB_NAME', getenv('POSTGRES_DB') ?: 'storeoman');
    define('DB_USER', getenv('POSTGRES_USER') ?: 'postgres');
    define('DB_PASS', getenv('POSTGRES_PASSWORD') ?: 'postgres');
    define('DB_PORT', getenv('POSTGRES_PORT') ?: '5432');
} else {
    // إعدادات MySQL (للرجوع للخلف)
    define('DB_HOST', getenv('MYSQL_HOST') ?: 'mysql');
    define('DB_NAME', getenv('MYSQL_DATABASE') ?: 'storeoman');
    define('DB_USER', getenv('MYSQL_USER') ?: 'storeoman_user');
    define('DB_PASS', getenv('MYSQL_PASSWORD') ?: 'storeoman_pass');
    define('DB_PORT', getenv('MYSQL_PORT') ?: '3306');
    define('DB_CHARSET', 'utf8mb4');
}

/**
 * الاتصال بقاعدة البيانات
 */
function getDBConnection() {
    try {
        if (DB_TYPE === 'pgsql') {
            // PostgreSQL Connection
            $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
        } else {
            // MySQL Connection
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        }
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
    }
}

/**
 * اختبار الاتصال بقاعدة البيانات
 */
function testDBConnection() {
    try {
        $pdo = getDBConnection();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * الحصول على نوع قاعدة البيانات
 */
function getDBType() {
    return DB_TYPE;
}
