## Planner5D fullstack test task

[Test task description](test-task-description.md)

Build backend:
```sh
  cp .env.example .env
  docker run --rm -v $(pwd):/app composer install
  docker-compose up -d
```

To generate APP_KEY and copy it to .env file:
```sh
  docker-compose exec app php artisan key:generate
```

Create database and apply migrations
```sh
  touch database/database.sqlite
  docker-compose exec app php artisan migrate
```

Build frontend:
```sh
  docker-compose exec app npm install
  docker-compose exec app npm run build
```

Import projects:
```sh
  docker-compose exec app php artisan app:import-projects
```

Open project:
[localhost](http://localhost/)
