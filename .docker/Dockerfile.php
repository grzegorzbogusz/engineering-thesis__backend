# Set master image
FROM php:8.1-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --version=2.4.2 --install-dir=/usr/local/bin --filename=composer