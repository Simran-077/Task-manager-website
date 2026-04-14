# Stage 1: Build frontend assets
FROM node:20 AS asset-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: PHP Application
FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    libpq-dev \
    libsqlite3-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql pdo_pgsql zip


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy application files
COPY . .

# Copy built assets from Stage 1
COPY --from=asset-builder /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions for Laravel
RUN chmod -R 775 storage bootstrap/cache

# Ensure the SQLite database exists (even if empty)
RUN touch database/database.sqlite && chmod 666 database/database.sqlite

# Cache routes and views (NOT config to allow runtime env vars)
RUN php artisan route:cache \
    && php artisan view:cache

# Create storage link
RUN php artisan storage:link


EXPOSE 10000

# Run migrations and start the server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000