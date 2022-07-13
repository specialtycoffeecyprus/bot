FROM php:8.1-cli-alpine

RUN docker-php-ext-enable opcache
RUN curl -sS --compressed https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY docker/php/ ${PHP_INI_DIR}/

WORKDIR /app/

COPY --chown=www-data:www-data composer.* ./

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN composer install --no-autoloader --no-dev --no-interaction --no-scripts

COPY --chown=www-data:www-data . .

RUN set -eux ; \
    chown -R www-data:www-data vendor ; \
    chmod -R -x+X . ; \
    composer dump-autoload --classmap-authoritative --optimize --no-interaction

EXPOSE 8080

CMD ["/usr/local/bin/php", "-S", "0.0.0.0:8080", "-t", "public"]
