# Base image: chọn Alpine nhẹ nhưng cài đủ extension cần thiết
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Cài các package cần thiết cho Laravel
RUN apk update && apk add --no-cache \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libxml2-dev \
    zip \
    bash \
    vim \
    oniguruma-dev \
    icu-dev \
    postgresql-dev \
    mysql-client \
    shadow \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring exif intl pcntl bcmath sockets

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copy source code Laravel
COPY . .

# Tạo folder cần thiết
RUN mkdir -p database/factories database/seeders storage/framework/cache/data \
    && touch database/factories/.gitkeep

# Set quyền cho storage & bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Cài Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose PHP-FPM port
EXPOSE 9000

# CMD chạy PHP-FPM
CMD ["php-fpm"]
