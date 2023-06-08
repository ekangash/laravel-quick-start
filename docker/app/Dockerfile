FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    wget \
    zlib1g-dev \
    libmcrypt-dev \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    openssl \
    git \
    curl \
    dpkg-dev \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    cron \
    && pecl channel-update pecl.php.net \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure gd --enable-gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN echo "memory_limit = 250M" >> /usr/local/etc/php/conf.d/custom.ini
RUN echo "xdebug.idekey = PHPSTORM" >> /usr/local/etc/php/conf.d/custom.ini
RUN echo "xdebug.mode = debug" >> /usr/local/etc/php/conf.d/custom.ini
RUN echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/custom.ini

RUN docker-php-ext-install pdo pdo_pgsql pgsql bcmath zip exif
RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quiet

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

WORKDIR /var/www

USER 1000:1000

CMD ["php-fpm"]
