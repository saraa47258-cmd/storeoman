# 🛍️ StoreOman - متجر إلكتروني

مشروع متجر إلكتروني مبني باستخدام HTML, CSS, JavaScript, PHP, و PostgreSQL.

## 📋 المتطلبات

- Docker
- Docker Compose
- PostgreSQL (اختياري - يمكن استخدام MySQL)

## 🚀 التثبيت

### 1. استنساخ المشروع

```bash
git clone https://github.com/username/storeoman.git
cd storeoman
```

### 2. إنشاء ملف .env

```bash
cp env.example .env
nano .env
```

### 3. تشغيل المشروع

```bash
docker-compose up -d --build
```

## 🌐 الوصول للموقع

- الصفحة الرئيسية: `http://localhost/`
- اختبار قاعدة البيانات: `http://localhost/test-db.php`

## 📁 هيكل المشروع

```
storeoman/
├── index.html          # الصفحة الرئيسية
├── styles.css          # ملف التنسيق
├── config.php          # إعدادات قاعدة البيانات
├── docker-compose.yml  # إعدادات Docker
├── Dockerfile.php      # صورة PHP مع PostgreSQL
├── nginx.conf          # إعدادات Nginx
└── init-postgres.sql   # تهيئة قاعدة البيانات
```

## 🔧 الأوامر المفيدة

```bash
# تشغيل المشروع
docker-compose up -d

# إيقاف المشروع
docker-compose down

# عرض السجلات
docker-compose logs -f

# إعادة بناء
docker-compose up -d --build
```

## 📝 التحديثات

للتحديث من GitHub:

```bash
git pull origin main
docker-compose restart
```

أو استخدم السكريبت:

```bash
./update.sh
```

## 🔒 الأمان

- لا ترفع ملف `.env` إلى GitHub
- استخدم كلمات مرور قوية
- احذف `phpinfo.php` بعد الاختبار

## 📄 الرخصة

هذا المشروع مفتوح المصدر.

## 👤 المؤلف

StoreOman Team
