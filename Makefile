all: composer-install unit-test
composer-install:
	docker compose run console composer install
unit-test:
	docker compose run --rm console ./vendor/bin/codecept run Unit
destroy:
	docker compose down --rmi all --volumes --remove-orphans
sh:
	docker compose run console bash
