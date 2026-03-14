# Используем многоступенчатую сборку эффективнее
FROM php:8.4-fpm AS base

WORKDIR /var/www/html/backend

# Установка системных зависимостей и PHP расширений
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nano \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Установка Composer глобально
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Этап установки зависимостей
FROM base AS vendor
COPY composer.json composer.lock ./
RUN composer install \
    --no-interaction \
    --no-progress \
    --no-suggest \
    --no-scripts \
    --ignore-platform-reqs

# Production этап
FROM base AS production
COPY --from=vendor /var/www/html/backend/vendor /var/www/html/backend/vendor
COPY . .

# Создаем директории и устанавливаем права
RUN mkdir -p /var/www/html/backend/storage/framework/sessions \
    && mkdir -p /var/www/html/backend/storage/framework/views \
    && mkdir -p /var/www/html/backend/storage/framework/cache \
    && mkdir -p /var/www/html/backend/storage/logs \
    && mkdir -p /var/www/html/backend/bootstrap/cache

# Права на storage и bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/backend/storage \
    && chown -R www-data:www-data /var/www/html/backend/bootstrap/cache \
    && chmod -R 775 /var/www/html/backend/storage \
    && chmod -R 775 /var/www/html/backend/bootstrap/cache

# Оптимизация для production
RUN composer dump-autoload --optimize \
    && php artisan optimize \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

RUN composer install --optimize-autoloader --no-dev \
    && php artisan optimize

USER www-data

EXPOSE 8000
CMD ["php-fpm"]
