FROM php:8.2-fpm

# -------------------------------------------------
# 1️⃣ Cài các thư viện hệ thống (GD + PostgreSQL + Oniguruma)
# -------------------------------------------------
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libzip-dev zip \
    libonig-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# -------------------------------------------------
# 2️⃣ Cấu hình PHP & Composer để tránh lỗi RAM
# -------------------------------------------------
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1
RUN echo "memory_limit = -1" > /usr/local/etc/php/conf.d/memory-limit.ini

# -------------------------------------------------
# 3️⃣ Cài Composer (bản chính thức)
# -------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# -------------------------------------------------
# 4️⃣ Set thư mục làm việc
# -------------------------------------------------
WORKDIR /var/www

# -------------------------------------------------
# 5️⃣ Copy file composer trước (để cache build hiệu quả)
# -------------------------------------------------
COPY composer.json composer.lock ./

# -------------------------------------------------
# 6️⃣ Cài dependencies (nhẹ & an toàn cho Render Free)
# -------------------------------------------------
RUN composer config --global process-timeout 900 && \
    COMPOSER_MEMORY_LIMIT=-1 composer install \
    --no-dev \
    --prefer-dist \
    --no-progress \
    --no-interaction \
    --no-scripts \
    --optimize-autoloader || true

# -------------------------------------------------
# 7️⃣ Copy toàn bộ source code Laravel
# -------------------------------------------------
COPY . .

# -------------------------------------------------
# 8️⃣ Phân quyền & clear cache Composer
# -------------------------------------------------
RUN mkdir -p /root/.composer && chmod -R 777 /root/.composer /var/www && composer clear-cache

# -------------------------------------------------
# 9️⃣ Clear cache Laravel (bỏ qua lỗi nếu .env chưa sẵn)
# -------------------------------------------------
RUN php artisan config:clear || true && \
    php artisan route:clear || true && \
    php artisan view:clear || true

# -------------------------------------------------
# 🔟 Expose port cho Render (bắt buộc là 8080)
# -------------------------------------------------
EXPOSE 8080

# -------------------------------------------------
# 11️⃣ Chạy migrate (nếu DB sẵn sàng) rồi khởi động server
# -------------------------------------------------
CMD php artisan migrate --force || true && php artisan serve --host=0.0.0.0 --port=$PORT
