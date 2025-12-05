# Sử dụng PHP 8.2 FPM làm base image
FROM php:8.2-fpm

# Cài các extension cần thiết cho Laravel + MySQL
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Cài composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Đặt thư mục làm việc
WORKDIR /var/www

# Copy toàn bộ mã nguồn vào container
COPY . /var/www

# Phân quyền storage & bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Cài dependency Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Mở cổng 9000 cho php-fpm
EXPOSE 9000

CMD ["php-fpm"]
