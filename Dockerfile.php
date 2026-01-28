# Dockerfile لـ PHP مع دعم PostgreSQL
FROM php:8.2-fpm-alpine

# تثبيت PostgreSQL extension
RUN apk add --no-cache \
    postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql

# تعيين الصلاحيات
RUN chmod -R 755 /var/www/html

WORKDIR /var/www/html
