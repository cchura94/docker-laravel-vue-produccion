echo "Levantando contenedores (DOCKER)"
cd backend_proyecto_laravue
docker-compose up -d --build

docker-compose exec -T laravel composer install
docker-compose exec -T laravel php artisan key:generate
docker-compose exec -T laravel php artisan optimize
docker-compose exec -T laravel php artisan migrate:fresh
docker-compose exec -T laravel php artisan db:seed

echo "La aplicación está en: localhost:80 o localhost:80/api"


