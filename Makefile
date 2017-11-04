.DEFAULT_GOAL := help
.PHONY: help

help:
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST) | sort

build: ## Build project
	composer install

test: ## Run tests
	docker-compose exec php-fpm bin/phpspec run
	docker-compose exec php-fpm bin/behat

run_local:  ## Run local environment
	sudo docker-compose up -d
