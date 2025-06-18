# Gunakan image dasar PHP dengan FPM
FROM php:8.1-fpm

# Install ekstensi dan dependency yang dibutuhkan
RUN apt-get update && apt-get install -y \
    libicu-dev \
    zip unzip \
    git \
    libonig-dev \
    libzip-dev \
    curl \
    libpng-dev \
    libxml2-dev \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    gd \
    mysqli

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set direktori kerja di dalam container
WORKDIR /var/www/html

# Copy semua file dari project ke dalam container
COPY . .

# Atur permission file agar cocok untuk user web
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port untuk PHP-FPM
EXPOSE 9000

# Jalankan PHP-FPM
CMD ["php-fpm"]
