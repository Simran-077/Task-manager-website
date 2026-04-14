FROM php:8.2-cli

RUN apt-get update && apt-get install -y unzip curl git

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000

RUN chmod -R 775 storage bootstrap/cache

RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache