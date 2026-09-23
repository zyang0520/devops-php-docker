FROM composer:2 AS vendor
WORKDIR /app
COPY backend/composer.json composer.json
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

FROM php:8.4-cli
WORKDIR /app
COPY --from=vendor /app/vendor ./vendor
COPY backend/ .
EXPOSE 8080
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
