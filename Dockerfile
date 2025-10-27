FROM php:8.2-fpm

# Cài các thư viện hệ thống
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Tăng bộ nhớ PHP (tránh lỗi Extracting archive)
RUN echo "memory_limit = -1" > /usr/local/etc/php/conf.d/memory-limit.ini

# Cài composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# Cấp quyền ghi (tránh lỗi permission)
RUN mkdir -p /root/.composer && chmod -R 777 /root/.composer
RUN chmod -R 777 /var/www

# Cập nhật composer và xóa cache hỏng
RUN composer self-update && composer clear-cache

# Cài Laravel dependencies an toàn
RUN composer install --prefer-dist --no-progress --no-interaction --optimize-autoloader

# Xóa cache cũ của Laravel
RUN php artisan config:clear && php artisan route:clear && php artisan view:clear

EXPOSE 8080
CMD php artisan serve --host=0.0.0.0 --port=$PORT
