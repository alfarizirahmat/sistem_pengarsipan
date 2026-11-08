FROM php:8.3-cli-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    curl \
    git \
    nodejs \
    npm \
    libpng-dev \
    libzip-dev \
    postgresql-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install frontend dependencies and build assets
RUN npm ci || npm install \
    && npm run build

# Create storage symlink and prepare permissions
RUN php artisan storage:link || true \
    && chmod -R 777 storage bootstrap/cache

EXPOSE 8000

# Start command
CMD php artisan migrate --force \
    && php artisan app:init-admin \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan serve --host=0.0.0.0 --port=8000

