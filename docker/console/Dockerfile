FROM php:8.2-cli

RUN apt update && apt install -y vim git unzip procps
RUN pecl install xdebug-3.2.1 && docker-php-ext-enable xdebug
COPY xdebug.ini /usr/local/etc/php/conf.d
COPY --from=composer /usr/bin/composer /usr/bin/composer

# ENTRYPOINT ["top", "-b"]
