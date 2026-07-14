FROM composer:2.5 as build
WORKDIR /app
COPY . /app/
RUN apk add --no-cache icu-dev && docker-php-ext-install intl
RUN composer install --no-dev --optimize-autoloader --no-interaction

FROM php:8.2
# Install required extensions
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite mbstring xml intl

# Set working directory
WORKDIR /app

# Copy application files from build stage
COPY --from=build /app /app

# Set permissions
RUN chmod -R 755 /app/writable

# Enable error display for debugging
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-error.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-error.ini

EXPOSE 8080

# Start PHP built-in server
CMD php -S 0.0.0.0:8080 -t public
