# استخدام صورة Nginx الرسمية
FROM nginx:alpine

# نسخ ملفات المشروع إلى مجلد الويب في Nginx
COPY index.html /usr/share/nginx/html/
COPY styles.css /usr/share/nginx/html/

# تعيين الصلاحيات
RUN chmod -R 755 /usr/share/nginx/html

# فتح المنفذ 80
EXPOSE 80

# تشغيل Nginx
CMD ["nginx", "-g", "daemon off;"]
