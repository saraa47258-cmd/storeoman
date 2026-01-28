# 🔗 ربط StoreOman مع postgres-docker

## 📋 الخطوات السريعة

### 1. التحقق من postgres-docker

```bash
# تحقق من أن postgres-docker يعمل
docker ps | grep postgres

# تحقق من اسم network
docker network ls
# ابحث عن: postgres-docker_default
```

### 2. إنشاء ملف .env

```bash
cp env.example .env
```

عدل ملف `.env`:
```env
DB_TYPE=pgsql
POSTGRES_HOST=postgres_db
POSTGRES_DB=storeoman
POSTGRES_USER=postgres
POSTGRES_PASSWORD=postgres
POSTGRES_PORT=5432
```

### 3. إنشاء قاعدة البيانات

```bash
# الاتصال بـ PostgreSQL
docker exec -it postgres_db psql -U postgres

# إنشاء قاعدة البيانات
CREATE DATABASE storeoman;

# الخروج
\q

# تنفيذ ملف init-postgres.sql
docker exec -i postgres_db psql -U postgres -d storeoman < init-postgres.sql
```

### 4. تشغيل المشروع

```bash
docker-compose up -d --build
```

### 5. اختبار الاتصال

افتح المتصفح:
```
http://localhost/test-db.php
```

## 🔍 التحقق من الربط

```bash
# تحقق من network
docker network inspect postgres-docker_default

# اختبار الاتصال من PHP إلى PostgreSQL
docker exec storeoman-php ping -c 3 postgres_db
```

## 📝 ملاحظات

- تأكد من أن postgres-docker يعمل قبل تشغيل storeoman
- اسم حاوية PostgreSQL: `postgres_db` (تحقق من docker ps)
- اسم network: `postgres-docker_default` (تحقق من docker network ls)
- إذا كانت الأسماء مختلفة، عدل ملف `.env` و `docker-compose.yml`
