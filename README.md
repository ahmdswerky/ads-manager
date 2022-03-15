
# Simple Scalable Ad-Manager

A simple Ad-Manager managed with Docker.

## Installation

01.Build with docker compose

```bash
  docker-compose build
```

02.Install dependencies

```bash
  docker-compose composer install
```

03.Copy .env file

```bash
  docker-compose run --rm php php -r "file_exists('/var/www/html/.env') ?: copy('/var/www/html/.env.example', '/var/www/html/.env');"
```

04.Generate Key

```bash
  docker-compose run --rm artisan key:generate
```

05.Run database migrations with seeders

```bash
  docker-compose run --rm artisan migrate --seed
```

## Usage

Start multiple instances (change 5 to specific servers in mind)

```bash
  docker-compose up --scale nginx=5
```

Check which ports are opened

```bash
  ./bin/ports.sh
```

Use artisan

```bash
  docker-compose run --rm artisan [command] [args]
```

## Running Tests

Run tests

```bash
  docker-compose run --rm artisan test
```

## License

This project is an open-sourced software licensed under the [MIT](https://opensource.org/licenses/MIT)
