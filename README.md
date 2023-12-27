# Installation

1. Install Docker
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up`
4. Run `docker exec -ti messaging-laravel.test-1  sh -c 'php artisan migrate:refresh'`
5. Open [http://localhost:8080](http://localhost:8080)
