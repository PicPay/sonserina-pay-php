setup:
	@docker-compose up -d --build
	@docker-compose exec -T app composer install -n

bash:
	@docker-compose exec app bash

test:
	@docker-compose exec -T app php ./vendor/bin/phpunit --coverage-text

test-coverage:
	@docker-compose exec -T app php ./vendor/bin/phpunit --coverage-html coverage

infection:
	@docker-compose exec -T app composer run-script infection

