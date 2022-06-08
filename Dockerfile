FROM php:8.1.0-fpm
RUN apt-get update -y && apt-get install -y libmcrypt-dev openssl && apt-get install -y git

RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app
COPY . /app
#mv /app/.env.docker /app/.env
#RUN composer install

CMD php artisan migrate
CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000
