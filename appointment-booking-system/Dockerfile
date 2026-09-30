
# Stage 1: Build frontend assets
FROM node:22-bookworm-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY . .

# Build production CSS and JavaScript
RUN npm run build


# Stage 2: Laravel / PHP runtime
FROM php:8.3-cli-bookworm

WORKDIR /var/www/html

# Install system libraries and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libsqlite3-dev \
    && docker-php-ext-install \
    pdo_mysql \
    pdo_sqlite \
    sqlite3 \
    mbstring \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy Laravel project
COPY . .

# Remove any local Vite development marker
RUN rm -f public/hot

# Copy compiled production assets
COPY --from=frontend /app/public/build ./public/build

# Install production PHP dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-progress

# Prepare Laravel writable directories
RUN mkdir -p \
    database \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache database

# Production environment
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV PORT=8080

EXPOSE 8080

# Start Laravel
CMD ["sh", "-c", "touch database/database.sqlite && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
