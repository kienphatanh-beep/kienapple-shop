# 1️⃣ Sử dụng PHP + Composer
FROM php:8.2-fpm

# 2️⃣ Cài extension cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# 3️⃣ Cài Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4️⃣ Sao chép source Laravel
WORKDIR /var/www/html
COPY . .

# 5️⃣ Cài đặt các package Laravel
RUN composer install --no-interaction --no-dev --optimize-autoloader

# 6️⃣ Tạo key và migrate database
RUN php artisan key:generate || true

# 7️⃣ Mở cổng
EXPOSE 10000

# 8️⃣ Lệnh chạy Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000
