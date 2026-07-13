FROM composer:2.5 as build
WORKDIR /app
COPY . /app/
RUN apk add --no-cache icu-dev && docker-php-ext-install intl
RUN composer install --no-dev --optimize-autoloader --no-interaction

FROM php:8.1-fpm
# Install required extensions
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libicu-dev \
    nginx \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli mbstring xml exif intl

# Set working directory
WORKDIR /var/www/html

# Copy application files from build stage
COPY --from=build /app /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/writable

# Configure nginx
COPY docker/nginx.conf /etc/nginx/sites-available/default
EXPOSE 80

# Start php-fpm and nginx
CMD php-fpm -D && nginx -g 'daemon off;'
