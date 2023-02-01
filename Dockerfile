FROM php:8.1-cli-alpine

RUN docker-php-ext-enable opcache
RUN curl -sS --compressed https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY docker/php/ ${PHP_INI_DIR}/

USER www-data:www-data
WORKDIR /var/www/html/

COPY --chown=www-data:www-data composer.* ./

RUN composer install --no-autoloader --no-ansi --no-cache --no-dev --no-interaction --no-progress --no-scripts

COPY --chown=www-data:www-data . .

RUN composer dump-autoload --classmap-authoritative --no-ansi --no-cache --no-interaction

EXPOSE 8080

CMD ["/usr/local/bin/php", "-S", "0.0.0.0:8080", "-t", "public", "app/router.php"]
