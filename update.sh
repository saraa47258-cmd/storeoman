#!/bin/bash

# سكريبت تحديث المشروع من GitHub

echo "═══════════════════════════════════════════════════════════"
echo "   تحديث مشروع StoreOman من GitHub"
echo "═══════════════════════════════════════════════════════════"
echo ""

# الانتقال إلى مجلد المشروع
cd /var/www/alshabibi/storeoman || exit

echo "📥 سحب التحديثات من GitHub..."
git pull origin main

if [ $? -eq 0 ]; then
    echo "✅ تم سحب التحديثات بنجاح"
    echo ""
    echo "🔄 إعادة تشغيل Docker..."
    docker-compose restart
    
    echo ""
    echo "✅ تم التحديث بنجاح!"
    echo ""
    echo "التحقق من الحالة:"
    docker-compose ps
else
    echo "❌ فشل سحب التحديثات"
    exit 1
fi
