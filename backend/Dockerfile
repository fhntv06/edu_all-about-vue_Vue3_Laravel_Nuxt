# Используем многоступенчатую сборку эффективнее
FROM php:8.4-fpm AS base

WORKDIR /var/www/html

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

# Финальный этап разработки
FROM base AS development
COPY --from=vendor /var/www/html/vendor /var/www/html/vendor
COPY . .

# Права на storage и bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

USER www-data

EXPOSE 9000
CMD ["php-fpm"]

# Production этап (можно добавить оптимизации)
FROM development AS production
RUN composer install --optimize-autoloader --no-dev \
    && php artisan optimize
