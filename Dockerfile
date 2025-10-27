FROM php:8.2-fpm

# -------------------------------------------------
# 1️⃣ Install system dependencies (with GD + PostgreSQL)
# -------------------------------------------------
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# -------------------------------------------------
# 2️⃣ Optimize PHP memory & disable interactive prompts
# -------------------------------------------------
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN echo "memory_limit = -1" > /usr/local/etc/php/conf.d/memory-limit.ini

# -------------------------------------------------
# 3️⃣ Install Composer (from Composer official image)
# -------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# -------------------------------------------------
# 4️⃣ Set working directory
# -------------------------------------------------
WORKDIR /var/www

# -------------------------------------------------
# 5️⃣ Copy only Composer files first (for Docker cache)
# -------------------------------------------------
COPY composer.json composer.lock ./

# -------------------------------------------------
# 6️⃣ Install dependencies efficiently (skip heavy scripts)
# -------------------------------------------------
RUN COMPOSER_MEMORY_LIMIT=-1 composer install \
    --no-dev \
    --prefer-dist \
    --no-progress \
    --no-interaction \
    --no-scripts \
    --optimize-autoloader \
    || true

# -------------------------------------------------
# 7️⃣ Copy full application source
# -------------------------------------------------
COPY . .

# -------------------------------------------------
# 8️⃣ Fix permissions & clear Composer cache
# -------------------------------------------------
RUN mkdir -p /root/.composer && chmod -R 777 /root/.composer /var/www && composer clear-cache

# -------------------------------------------------
# 9️⃣ Clear Laravel caches safely (ignore if .env missing)
# -------------------------------------------------
RUN php artisan config:clear || true && \
    php artisan route:clear || true && \
    php artisan view:clear || true

# -------------------------------------------------
# 🔟 Expose port for Render
# -------------------------------------------------
EXPOSE 8080

# -------------------------------------------------
# 11️⃣ Run migrations automatically, then start Laravel
# -------------------------------------------------
CMD php artisan migrate --force || true && php artisan serve --host=0.0.0.0 --port=$PORT
