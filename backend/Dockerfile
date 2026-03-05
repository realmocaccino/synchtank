# Use PHP 8.2 with CLI, FPM, and extensions
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libonig-dev default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql intl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# Expose port 8000 for PHP-FPM
EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]