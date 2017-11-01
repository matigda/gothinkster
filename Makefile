.DEFAULT_GOAL := help
.PHONY: help

help:
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST) | sort

build: ## Build project
	composer install

test: ## Run tests
	bin/phpspec run
	bin/behat

run_local:  ## Run local environment
	docker-compose up -d

lint: ## Run qa checks
	docker run -it --rm -v $(PWD):/app -w /app jakzal/phpqa:alpine php-cs-fixer fix --dry-run --diff src
	docker run -it --rm -v $(PWD):/app -w /app jakzal/phpqa:alpine phpstan --level=7 analyse src

codestyle-fix:
	docker run -it --rm -v $(PWD):/app -w /app jakzal/phpqa:alpine php-cs-fixer fix src
