#!/usr/bin/make
include .env
export

.PHONY: help
.DEFAULT_GOAL := help

help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

##@ Composer

install: ## Composer install dependencies
	docker exec -it ${DOCKER_APP_SERVICE_NAME} composer install -o

require: ## Run the composer require. (e.g make require PACKAGE="vendor/package")
	docker exec -it ${DOCKER_APP_SERVICE_NAME} composer require ${PACKAGE}

dump: ## Run the composer dump
	docker exec -it ${DOCKER_APP_SERVICE_NAME} composer dump-autoload

##@ Database

db-backup: ## Backup database
	docker exec ${DOCKER_DB_SERVICE_NAME} /usr/bin/mysqldump -u root -p${DB_PASSWORD} ${DB_DATABASE} > backup.sql

db-restore: ## Restore database
	cat backup.sql | docker exec -i ${DOCKER_DB_SERVICE_NAME} /usr/bin/mysql -u root -p${DB_PASSWORD} ${DB_DATABASE}

##@ Laravel

controller: ## Create a new controller class (e.i: make controller NAME="XptoController")
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan make:controller ${NAME}

cache: ## Flush the application cache
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan cache:clear

routeList: ## List all registered routes
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan route:list

routeCache: ## Create a route cache file for faster route registration
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan route:cache

routeClear: ## Remove the route cache file
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan route:clear

migration: ## Create a new migration file (e.i: make migration NAME="create_table_name" | NAME="create_table_name --create=table")
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan make:migration ${NAME}

migrate: ## Runs migrations
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan migrate

rollback: ## Rollback the last database migration with steps (e.i: make rollback --steps=2)
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan migrate:rollback --step=${STEPS}

rollbackAll: ## Rollback the last database migration (e.i: make rollback)
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan migrate:rollback

refresh: ## Reset and re-run migrations with steps (e.i: make refresh STEPS=2)
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan migrate:refresh --step=${STEPS}

refreshAll: ## Reset and re-run all migrations
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan migrate:refresh

fresh: ## Drop all tables and re-run all migrations
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan migrate:fresh

model: ## Create a new Eloquent model class (e.i: make model NAME="Post" | NAME="Post -m")
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan make:model ${NAME}

seeder: ## Create a new seeder class (e.i: make seeder NAME="UserTableSeeder")
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan make:seeder ${NAME}

seed: ## Seed the database with records
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan db:seed

factory: ## Create a new model factory (e.i: make factory NAME="PostFactory")
	docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan make:factory ${NAME}
