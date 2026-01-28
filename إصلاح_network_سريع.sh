#!/bin/bash

# سكريبت سريع لإصلاح مشكلة network

echo "═══════════════════════════════════════════════════════════"
echo "   إصلاح مشكلة network postgres-docker_default"
echo "═══════════════════════════════════════════════════════════"
echo ""

# الانتقال إلى مجلد المشروع
cd /var/www/alshabibi/storeoman || exit

echo "🔍 البحث عن networks الموجودة..."
echo ""
docker network ls
echo ""

# البحث عن network الخاص بـ postgres-docker
POSTGRES_NETWORK=$(docker network ls | grep -i postgres | awk '{print $2}' | head -1)

if [ -z "$POSTGRES_NETWORK" ]; then
    echo "⚠️  لم يتم العثور على network لـ postgres-docker"
    echo ""
    echo "هل تريد إنشاء network جديد باسم postgres-docker_default؟ (y/n)"
    read -r answer
    
    if [ "$answer" = "y" ] || [ "$answer" = "Y" ]; then
        echo "🌐 إنشاء network جديد..."
        docker network create postgres-docker_default
        echo "✅ تم إنشاء network بنجاح"
    else
        echo "❌ لم يتم إنشاء network"
        echo "   يمكنك إنشاؤه يدوياً: docker network create postgres-docker_default"
        exit 1
    fi
else
    echo "✅ تم العثور على network: $POSTGRES_NETWORK"
    echo ""
    echo "⚠️  إذا كان الاسم مختلفاً، يجب تعديل docker-compose.yml"
    echo "   استبدل 'postgres-docker_default' بـ '$POSTGRES_NETWORK'"
fi

echo ""
echo "🔄 إعادة تشغيل المشروع..."
docker-compose down
docker-compose up -d --build

echo ""
echo "✅ تم!"
echo ""
echo "التحقق من الحالة:"
docker-compose ps
