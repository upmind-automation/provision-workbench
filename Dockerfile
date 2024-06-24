FROM php:8.1-apache

ENV APACHE_DOCUMENT_ROOT /provision-workbench/public
ENV APACHE_RUN_DIR /var/lib/apache2/runtime
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_RUN_USER apache
ENV APACHE_RUN_GROUP apache

RUN mkdir -p ${APACHE_RUN_DIR}

RUN useradd apache

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    unzip \
    libicu-dev \
    libxml2-dev \
    uuid-dev \
    libsodium-dev

RUN docker-php-ext-install zip intl soap sodium

RUN pecl install xdebug-3.2.1 \
    && pecl install uuid \
    && docker-php-ext-enable xdebug uuid

COPY docker/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN mkdir -p /var/log/php/ \
    && touch /var/log/php/xdebug.log \
    && chmod 777 /var/log/php/xdebug.log

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /provision-workbench

COPY docker/start.sh docker/start.sh

RUN chmod +x docker/start.sh

VOLUME ["/provision-workbench"]

EXPOSE 80/tcp
EXPOSE 9000

CMD ["docker/start.sh"]