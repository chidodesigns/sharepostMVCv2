FROM php:7.4-apache
LABEL maintainer="Chido Ukaigwe"
COPY .docker/php/php.ini /usr/local/etc/php/
COPY ./setup.sql /docker-entrypoint-initdb.d/setup.sql
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY composer.json composer.json
COPY composer.lock composer.lock
COPY . .
RUN composer dump-autoload
RUN chmod +x /docker-entrypoint-initdb.d/setup.sql
COPY .docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install opcache \
    && a2enmod rewrite negotiation \

