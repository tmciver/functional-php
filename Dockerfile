FROM composer

WORKDIR /var/functional-php
COPY composer.json composer.lock ./
RUN composer update raphhh/trex-reflection
RUN composer install

COPY . .

ENTRYPOINT ["./vendor/bin/phpunit", "--bootstrap", "./vendor/autoload.php"]
