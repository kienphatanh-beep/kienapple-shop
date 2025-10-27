FROM php:8.2-fpm

# ------------------------------
# 1️⃣ Install system dependencies
# ------------------------------
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip bcmath gd

# ------------------------------
# 2️⃣ Increase PHP memory limit to avoid OOM (Out of Memory)
# ------------------------------
RUN echo "memory_limit = -1" > /usr/local/etc/php/conf.d/memory-limit.ini

# ------------------------------
# 3️⃣ Install Composer
# ------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ------------------------------
# 4️⃣ Set working directory
# ------------------------------
WORKDIR /var/www

# ------------------------------
# 5️⃣ Copy app source code
# ------------------------------
COPY . .

# ------------------------------
# 6️⃣ Set permissions
# ------------------------------
RUN mkdir -p /root/.composer && chmod -R 777 /root/.composer /var/www

# ------------------------------
# 7️⃣ Clear composer cache and update to latest version
# ------------------------------
RUN composer self-update && composer clear-cache

# ------------------------------
# 8️⃣ Install PHP dependencies safely (ignore scripts to prevent Artisan errors)
# ------------------------------
RUN COMPOSER_MEMORY_LIMIT=-1 composer install \
    --prefer-dist --no-dev --no-progress --no-interaction --optimize-autoloader --no-scripts

# ------------------------------
# 9️⃣ Clear Laravel caches (ignore errors if .env not ready)
# ------------------------------
RUN php artisan config:clear || true && \
    php artisan route:clear || true && \
    php artisan view:clear || true

# ------------------------------
# 🔟 Expose Render web port
# ------------------------------
EXPOSE 8080

# ------------------------------
# 11️⃣ Start Laravel using built-in PHP server
# ------------------------------
CMD php artisan serve --host=0.0.0.0 --port=$PORT
