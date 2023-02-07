FROM php:8.2-cli-alpine

RUN apk add --no-cache --virtual .build-dependencies $PHPIZE_DEPS \
    && pecl install apcu \
    && docker-php-ext-enable apcu opcache \
    && pecl clear-cache \
    && apk del .build-dependencies \
    && rm -fr /tmp/* /usr/src/* /usr/local/include/ /usr/local/lib/php/build/ /usr/local/lib/php/doc/ /usr/local/lib/php/test/ /usr/local/php/

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY docker/ /

USER www-data:www-data
WORKDIR /var/www/html/

COPY --chown=www-data:www-data composer.* ./

RUN composer install --no-autoloader --no-ansi --no-cache --no-dev --no-interaction --no-progress --no-scripts

COPY --chown=www-data:www-data . .

RUN composer dump-autoload --classmap-authoritative --no-ansi --no-cache --no-interaction

EXPOSE 8080

CMD ["/usr/local/bin/php", "-S", "0.0.0.0:8080", "-t", "public", "app/router.php"]
