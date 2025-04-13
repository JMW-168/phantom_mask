# backend/Dockerfile

FROM php:8.2-cli

# 安裝必要工具與 extensions
RUN apt-get update && apt-get install -y \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    zip \
    curl \
    && docker-php-ext-install pdo_mysql

# 安裝 Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
