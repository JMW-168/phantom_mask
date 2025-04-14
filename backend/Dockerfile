FROM php:8.2-cli

# 安裝必要工具與 PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    zip \
    curl \
    && docker-php-ext-install pdo_mysql

# 安裝 Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 設定工作目錄
WORKDIR /var/www

# ⬅️ 複製上層資料夾內容到容器中
COPY ./backend ./

COPY backend/.env.production .env

# 安裝 Laravel 相依套件
RUN composer install --no-dev --optimize-autoloader

# 預設啟動 Laravel 伺服器
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
