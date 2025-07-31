# Use the official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    unzip \
    git \
    libmariadb-dev \
    && rm -rf /var/lib/apt/lists/*

# Install pdo_mysql, intl, zip, and mysqli extensions
RUN docker-php-ext-install pdo_mysql intl zip mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set the working directory to /var/www/html (this is the container's main app root)
WORKDIR /var/www/html

# Copy Apache configuration (now in the new root)
COPY apache_setting.conf /etc/apache2/sites-available/000-default.conf

# Composer installation
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# --- MODIFIED: Composer files and installation now relative to the new root ---
# Copy composer files from the current build context root (which is the new project root)
COPY composer.json composer.lock ./

# Composer commands run directly in /var/www/html
RUN composer diagnose || true
RUN composer validate || true
RUN composer update --no-dev --no-interaction
RUN composer clear-cache
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN composer dump-autoload --optimize

# Verify vendor/autoload.php exists and is readable
RUN ls -l vendor/autoload.php || (echo "ERROR: vendor/autoload.php not found after composer install!" && exit 1)
RUN head -n 5 vendor/autoload.php # Show first few lines to confirm content

# Copy the rest of the CodeIgniter app files from the current build context root
# This will merge with the vendor/ directory already built
COPY . .
# --- END MODIFIED ---

# --- Set correct permissions for CodeIgniter's writable and vendor directories ---
# These paths are relative to the current WORKDIR (/var/www/html/)
RUN chown -R www-data:www-data writable/ vendor/
RUN chmod -R 775 writable/ vendor/
# --- END ADDED ---

# Optional: Run a CodeIgniter CLI command to test database connectivity during build
# This command needs to be run from the CodeIgniter root, which is /var/www/html/
RUN php spark db:list || true

# Expose port 80
EXPOSE 80

# The WORKDIR is already /var/www/html, no need to reset
