FROM php:8.2-fpm-alpine

# Đặt thư mục làm việc
WORKDIR /var/www/app

# Cài đặt các package cần thiết
RUN apk update && apk add --no-cache \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libxml2-dev \
    oniguruma-dev \
    icu-dev \
    bash \
    vim \
    linux-headers \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        gd \
        mbstring \
        exif \
        intl \
        pcntl \
        bcmath \
        sockets

# Cài node & npm (để build frontend nếu cần)
RUN apk add --no-cache nodejs npm

# Cài composer từ image composer chính thức
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copy toàn bộ mã nguồn vào container
COPY . .

# Phân quyền để tránh lỗi khi Laravel ghi log/cache
RUN chmod -R 777 /var/www/app/storage /var/www/app/bootstrap/cache

# Mở port 9000 cho PHP-FPM
EXPOSE 9000

# Khởi động PHP-FPM
CMD ["php-fpm"]
