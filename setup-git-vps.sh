#!/bin/bash

# سكريبت إعداد Git على VPS وربطه مع GitHub

echo "═══════════════════════════════════════════════════════════"
echo "   إعداد Git على VPS وربطه مع GitHub"
echo "═══════════════════════════════════════════════════════════"
echo ""

# الانتقال إلى مجلد المشروع
cd /var/www/alshabibi/storeoman || exit

# التحقق من تثبيت Git
if ! command -v git &> /dev/null; then
    echo "📦 تثبيت Git..."
    sudo apt update
    sudo apt install -y git
fi

echo "✅ Git مثبت"
echo ""

# تهيئة Git (إذا لم يكن موجوداً)
if [ ! -d .git ]; then
    echo "🔧 تهيئة Git..."
    git init
    git config user.name "StoreOman VPS"
    git config user.email "vps@storeoman.com"
fi

# ربط مع GitHub
echo "🌐 ربط مع GitHub..."
git remote remove origin 2>/dev/null
git remote add origin https://github.com/saraa47258-cmd/storeoman.git

echo ""
echo "✅ تم الإعداد!"
echo ""
echo "للسحب من GitHub:"
echo "  git pull origin main"
echo ""
echo "للرفع إلى GitHub (يتطلب Personal Access Token):"
echo "  git add ."
echo "  git commit -m 'تحديثات'"
echo "  git push origin main"
