# Use an official PHP runtime as a parent image
FROM php:8.2

# Set the working directory to /app
WORKDIR /app

# Copy the current directory contents into the container at /app
COPY . /app

# Install any needed packages
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev

# Install any needed PHP extensions
RUN docker-php-ext-install pdo_mysql zip
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

# Expose the port for Apache
EXPOSE 8000

CMD php artisan serve --host 0.0.0.0:8000

# Start the Apache server
#CMD ["apache2-foreground"]
