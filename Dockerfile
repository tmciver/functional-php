FROM composer

WORKDIR /var/functional-php
COPY composer.json composer.lock ./
RUN composer install

COPY . .

ENTRYPOINT ["./vendor/bin/phpunit", "--bootstrap", "./vendor/autoload.php"]
