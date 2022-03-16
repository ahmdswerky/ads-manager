
# Simple Scalable Ad-Manager

A simple Ad-Manager API with Laravel managed with Docker.

## Features

- Cashing with Redis database.
- Queueing system for mailing.
- Unit/Http testing.
- Easy, dockerized application.
- Centeral logginf with fluentd.

## Installation

01.Build with docker compose

```bash
  docker-compose build
```

02.Install dependencies

```bash
  docker-compose run --rm composer install
```

03.Copy .env file

```bash
  docker-compose run --rm php php -r "file_exists('/var/www/html/.env') ?: copy('/var/www/html/.env.example', '/var/www/html/.env');"
```

04.Generate Key

```bash
  docker-compose run --rm artisan key:generate
```

05.Clear cache

```bash
  docker-compose run --rm artisan cache:clear
```

06.Run database migrations with seeders

```bash
  docker-compose run --rm artisan migrate --seed
```

## Usage

Spin up containers with multiple nginx instances (change 5 to control servers number)

```bash
  docker-compose up --scale nginx=5
```

Spin down docker containers

Check which ports are opened

```bash
  ./bin/ports.sh
```

Use artisan

```bash
  docker-compose run --rm artisan [command] [args]
```

Use composer

```bash
  docker-compose run --rm composer [command] [args]
```

## Services & Ports

- MySQL :3306
- Nginx (Servers) :6000-:6050 (random)
- Mailhog [:8025](http://localhost:8025)
- Mailhog :1025
- Redis :6379

## Running Tests

Run tests

```bash
  docker-compose run --rm artisan test
```

## API Reference

[Postman Collection](https://documenter.getpostman.com/view/5216161/UVsLSmhX)

OR [Download and start using the collection from here](./resources/Ads-Manager.postman_collection-2022-03-16.json)

### Filters

### Get advertiser's ads

```http
  GET /api/ads?user={user_id}
```

### Get advertiser's by specific tags

```http
  GET /api/ads?tags={tag_1},{tag_2},{tag_3}
```

### Get advertiser's by specific category

```http
  GET /api/ads?category={category_id}
```

## Notes

- Make sure to stop all services using the mentioned ports at [Running Tests](#running-tests), or change ports at docker-compose.yml file according to your needs.

## License

This project is an open-sourced software licensed under the [MIT](https://opensource.org/licenses/MIT)
