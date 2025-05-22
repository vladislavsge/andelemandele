# Setup

Its required that one has [docker-compose](https://docs.docker.com/compose/install/) on the machine installed.

## Step 1: Copy files in your directory

Create a .env file and copy all into:

```
APP_NAME=andelemandele
APP_URL=http://andelemandele-test.docker
APP_ENV=local
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_KEY=base64:mbUxSBdGvuJLN5VcDlaruZrhTxon5Eq868GSsaeAztY=""

DB_HOST=172.18.0.2
DB_PORT=3306
DB_DATABASE=andelemandele
DB_USERNAME=andelemandele
DB_PASSWORD=andelemandele
DB_CONNECTION=mysql

MAIL_DRIVER=log

```

## Step 2: Execute docker

Run container

  ```sh
  docker-compose up -d --build
  ```


## Step 3: Install Composer dependencies

Bash into your container:

  ```sh
  docker-compose exec app bash
  ```

Install composer dependencies (this may also take a moment):

  ```sh
  composer install
  ```

and finally generate a key

  ```sh
  php artisan key:generate
  ```

also you need to add a new host `127.0.0.1 andelemandele-test.docker` to the `/etc/hosts` file in your system

Your app should now be accessible under `andelemandele-test.docker`



## API calls:

URLs:

* http://andelemandele-test.docker/api/characters or http://andelemandele-test.docker/api/characters?page=2
  These URLs returns all characters by page number or without it.

* http://andelemandele-test.docker/api/characters/episode/{episodeId} 
  This URL returns all characters by Episode ID

* http://andelemandele-test.docker/api/characters/search?name=Rick&status=Dead
  This URL search characters by name or status

* http://andelemandele-test.docker/api/characters/{id}
  This URL return character by ID
