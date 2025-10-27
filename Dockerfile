FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip bcmath

# Increase PHP memory limit to avoid OOM errors
RUN echo "memory_limit = -1" > /usr/local/etc/php/conf.d/memory-limit.ini

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app files
COPY . .

# Set permissions
RUN chmod -R 777 /var/www && mkdir -p /root/.composer && chmod -R 777 /root/.composer

# Clear and update composer
RUN composer self-update && composer clear-cache

# Install dependencies safely
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --prefer-dist --no-dev --no-progress --no-interaction --optimize-autoloader

# Clear Laravel caches
RUN php artisan config:clear && php artisan route:clear && php artisan view:clear || true

# Expose port for Render
EXPOSE 8080

# Start Laravel using PHP built-in server
CMD php artisan serve --host=0.0.0.0 --port=$PORT
