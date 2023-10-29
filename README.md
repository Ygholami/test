Make sure you have Docker and Docker Compose installed

git clone https://github.com/Ygholami/laravel.git

cd in project

docker-compose up -d

create database test in your db container

docker-compose exec -T test_app composer install

docker-compose exec -T test_app cp .env.example .env

docker-compose exec -T test_app php artisan migrate --seed

docker-compose exec -T test_app php artisan key:generate

docker-compose exec -T test_app php artisan l5-swagger:generate


//for run daily job to calculate total amount
docker-compose exec -T test_app php artisan schedule:work


