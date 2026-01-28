#!/bin/bash

# سكريبت مزامنة المشروع مع GitHub (مع حفظ ملف .env)

echo "═══════════════════════════════════════════════════════════"
echo "   مزامنة المشروع مع GitHub"
echo "═══════════════════════════════════════════════════════════"
echo ""

# الانتقال إلى مجلد المشروع
cd /var/www/alshabibi/storeoman || exit

# حفظ ملف .env
if [ -f .env ]; then
    echo "💾 حفظ ملف .env..."
    cp .env /tmp/storeoman.env.backup
    echo "✅ تم حفظ .env في /tmp/storeoman.env.backup"
else
    echo "⚠️  ملف .env غير موجود"
fi

# حفظ ملفات أخرى مهمة
echo "💾 حفظ ملفات إضافية..."
mkdir -p /tmp/storeoman_backup
cp -f docker-compose.yml /tmp/storeoman_backup/ 2>/dev/null
cp -f nginx.conf /tmp/storeoman_backup/ 2>/dev/null

# إعادة تعيين المشروع من GitHub
echo "🔄 مزامنة مع GitHub..."
git fetch origin
git reset --hard origin/main

# استعادة ملف .env
if [ -f /tmp/storeoman.env.backup ]; then
    echo "📥 استعادة ملف .env..."
    cp /tmp/storeoman.env.backup .env
    echo "✅ تم استعادة .env"
fi

# إعادة تشغيل Docker
echo "🔄 إعادة تشغيل Docker..."
docker-compose restart

echo ""
echo "✅ تمت المزامنة بنجاح!"
echo ""
echo "التحقق من الحالة:"
docker-compose ps
