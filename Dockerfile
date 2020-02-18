FROM php:7.2-apache

RUN apt-get update

ENV APP_HOME /var/www/html

RUN apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite headers

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --chown=www-data:www-data . $APP_HOME/

RUN composer update

RUN composer dump-autoload

RUN chmod -R 777  /var/www/html/storage /var/www/html/bootstrap

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN chown -R www-data:www-data $APP_HOME

RUN php artisan key:generate
RUN php artisan cache:clear
RUN php artisan config:cache
#RUN php artisan migrate
