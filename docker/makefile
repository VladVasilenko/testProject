container_app = app
container_db = db
app_command = docker exec $(container_app)
container_volume_db = docker_db

clean: #clean
	docker-compose down
	docker volume rm $(container_volume_db)

build: #build containers
	docker-compose build
	docker-compose up -d

composer-install: #composer install
	$(app_command) composer install

migrate: #start migrations
	$(app_command) php yii migrate --interactive=0

init-yii: #init yii
	$(app_command) php init --env=Development --overwrite=All

common-config: #copy common params
	$(app_command) cp docker/dev/common/config/main-local.php common/config/main-local.php
	$(app_command) cp docker/dev/api/config/main-local.php api/config/main-local.php

init: #full init app
	#build containers
	make build
	#composer install
	make composer-install
	#init yii
	make init-yii
	#init config
	make common-config
	#start migrations
	make migrate
	#seed test users
	make seed
	@echo "init app complete"

seed: #seed test users
	$(app_command) php yii seed/users

up: #up containers
	docker-compose up -d

down: #down containers
	docker-compose down

restart-docker:
	sudo service docker restart

enter:
	docker exec -it app bash

enter-db:
	docker exec -it db bash

rebuild:
	docker-compose down && docker-compose up -d --build

restart:
	docker-compose down && docker-compose up -d