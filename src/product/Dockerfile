
# Usando a imagem oficial do PHP 8.2 com Apache
FROM php:8.2-apache

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do projeto
COPY . .

# Definir variáveis de ambiente
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar dependências do Composer
RUN composer install
# Instalar JWT Auth
RUN composer require php-open-source-saver/jwt-auth

# Publicar a configuração do JWT Auth
RUN php artisan vendor:publish --provider="PHPOpenSourceSaver\\JWTAuth\\Providers\\LaravelServiceProvider"

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

RUN php artisan config:clear

RUN php artisan migrate

CMD php artisan serve --host=0.0.0.0 --port=8000

EXPOSE 8000
