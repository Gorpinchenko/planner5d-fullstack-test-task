## Planner5D fullstack test task

Build:
```sh
  cp .env.example .env
  docker run --rm -v $(pwd):/app composer install
  docker-compose up -d
```

To generate APP_KEY and copy it to .env file:
```sh
  docker-compose exec app php artisan key:generate
```
