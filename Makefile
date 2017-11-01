.DEFAULT_GOAL := help
.PHONY: help

help:
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST) | sort

build: ## Build project
	docker-compose exec -T php-fpm composer install

test: ## Run tests
	bin/phpspec run
	bin/behat

run_local:  ## Run local environment
	docker-compose up -d
