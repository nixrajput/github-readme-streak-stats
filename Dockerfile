# PHP 8.5, the version the Vercel runtime (vercel-php@0.9.0) runs
FROM php:8.5.13-apache@sha256:0a785eab8b7eb4836f9c6093771c8ea15ff8ba7269444f3da70a1d33d15fe664

# Install system dependencies and PHP extensions in one layer
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libicu-dev \
    inkscape \
    fonts-dejavu-core \
    curl \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer/composer:2.11.2-bin@sha256:4eaf89f62eb9504807f2828f1829a71b7fcd202e89abe2f41c1fb2136068fbfb /composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
COPY api/ ./api/
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Configure Apache to serve from api/ directory and pass environment variables
RUN a2enmod rewrite headers && \
    echo 'ServerTokens Prod\n\
    ServerSignature Off\n\
    PassEnv TOKEN\n\
    PassEnv WHITELIST\n\
    <VirtualHost *:80>\n\
    ServerAdmin webmaster@localhost\n\
    DocumentRoot /var/www/html/api\n\
    <Directory /var/www/html/api>\n\
    Options -Indexes\n\
    AllowOverride None\n\
    Require all granted\n\
    Header always set Access-Control-Allow-Origin "*"\n\
    Header always set Content-Type "image/svg+xml" "expr=%{REQUEST_URI} =~ m#\\.svg$#i"\n\
    Header always set Content-Security-Policy "default-src 'none'; style-src 'unsafe-inline'; img-src data:;" "expr=%{REQUEST_URI} =~ m#\\.svg$#i"\n\
    Header always set Referrer-Policy "no-referrer-when-downgrade"\n\
    Header always set X-Content-Type-Options "nosniff"\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
    </VirtualHost>' > /etc/apache2/sites-available/000-default.conf

RUN mkdir -p /var/www/html/cache

# Set secure permissions (cache dir needs write access for www-data)
RUN chown -R www-data:www-data /var/www/html && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \; && \
    chmod 775 /var/www/html/cache

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/demo/ || exit 1

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
