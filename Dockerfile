FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Cài package cần thiết + headers để build sockets
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
    linux-headers \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring exif intl pcntl bcmath sockets

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Copy source code
COPY . .

# Tạo folder cần thiết
RUN mkdir -p database/factories database/seeders storage/framework/cache/data \
    && touch database/factories/.gitkeep

# Set quyền
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Cài Composer dependencies
RUN composer install --no-dev --optimize-autoloader

EXPOSE 9000
CMD ["php-fpm"]
