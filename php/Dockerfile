FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    zip \
    libzip-dev \
    wget \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo pdo_mysql
# Composerni o'rnatish
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && apt-get install -y default-mysql-client && rm -rf /var/lib/apt/lists/*
WORKDIR /var/www/html

CMD ["php-fpm"]