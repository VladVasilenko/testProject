## Usage application

- http://127.0.0.0:8082 - API

## API
    • POST /requests: подача заявки на займ
    • GET /processor: обработка заявок

## Install application for developer

As a result of the installation, you will receive docker containers (`app`, `app-api`, `db`),
volume for storing database files - `db`, internal network for the interaction of containers - `app-network`.
Used xdebug 2.9.6 on port 9000.

1. Install the latest stable version of [docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/) and don't forget about [post-installation steps for Linux](https://docs.docker.com/install/linux/linux-postinstall/).

2. Install the latest stable version of [docker compose](https://docs.docker.com/compose/install/).

3. Install the latest stable version of `make` utility using `sudo apt install build-essential`.

4. Change to directory `/docker`.

5. Run `make init` to create dev environment, install application and seed test users (in the amount of 10).

6. Run `make clean` to remove dev environment and test data.

7. Other commands:
- `make build` to build and up docker containers.
- `make composer-install` to run `composer install` in container `app`.
- `make init-yii` to initialisation YII in container `app`.
- `make migrate` to start migrations in container `app`.
- `make up` to up docker containers.
- `make down` to stop docker containers.
- `make common-config` to copy common config (starting configuration).
- `make seed` to seed test users.
- `make enter` to enter at app container.
- `make enter-db` to enter at db container.
- `make rebuild` to rebuild docker environment.
- `make restart` to restart docker environment.

## Комментарии
- На все было затрачено около 6-7 часов, 75% времени было затрачено на настройку окружения (вырезал fronted, backend), вынес api в отедельный раздел
- Не стал добавлять prod окружение 