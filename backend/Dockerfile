# Use PHP 8.2 with CLI, FPM, and extensions
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libicu-dev libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql intl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# Expose port 9000 for PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]