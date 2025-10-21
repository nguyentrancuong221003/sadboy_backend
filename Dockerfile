FROM php:8.2-fpm-alpine

# Đặt thư mục làm việc
WORKDIR /var/www/app

# Cài đặt các package cần thiết
RUN apk update && apk add --no-cache \
    curl \
    zip \
    unzip \
    git \
    oniguruma-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libxml2-dev \
    bash \
    nodejs \
    npm

# Cấu hình và cài đặt các PHP extension
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        gd \
        exif

# Bật extension exif (cho Laravel Filemanager)
RUN docker-php-ext-enable exif

# Cài composer từ image chính thức
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Phân quyền thư mục làm việc
RUN chmod -R 777 /var/www/app

# Chạy PHP-FPM
CMD ["php-fpm"]
