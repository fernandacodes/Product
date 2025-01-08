# Usando a imagem oficial do PHP 8.2 com Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev  # Dependência do PostgreSQL

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd  # Adicionando a extensão do PostgreSQL

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Define user (se necessário)
USER $user

# Iniciar o servidor do Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000

EXPOSE 8000
