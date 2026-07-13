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
RUN docker-php-ext-install pdo pdo_mysql mysqli mbstring xml exif intl

# Set working directory
WORKDIR /app

# Copy application files from build stage
COPY --from=build /app /app

# Set permissions
RUN chmod -R 755 /app/writable

EXPOSE 8080

# Start PHP built-in server
CMD php -S 0.0.0.0:8080 -t public
