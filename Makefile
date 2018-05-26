.PHONY: test

test:
	docker run --rm -it -v `pwd`:/app --user `id -u`:`id -g` composer /bin/bash -c "composer install && composer dumpautoload && ./vendor/bin/phpunit --bootstrap ./vendor/autoload.php test"
