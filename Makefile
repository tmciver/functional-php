.PHONY: test docs

test:
	docker run --rm -it -v `pwd`:/app --user `id -u`:`id -g` composer:1.6.5 /bin/bash -c "composer install && composer dumpautoload && ./vendor/bin/phpunit"

docs:
	$(MAKE) -C docs/img/dot
