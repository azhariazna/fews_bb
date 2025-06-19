FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan CI4
RUN apt-get update && apt-get install -y \
    libzip-dev unzip zip libpng-dev libonig-dev libxml2-dev \
    libicu-dev g++ \
    default-mysql-client \
    && docker-php-ext-install intl mysqli pdo pdo_mysql zip intl

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Salin semua isi folder project ke Apache
COPY . /var/www/html

# Set direktori kerja
WORKDIR /var/www/html

# Atur permission
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Konfigurasi Apache agar .htaccess aktif
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
