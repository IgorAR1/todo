<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Тестовое задание "ToDo list"
## Как поднять проект
    #В терминале:
- cp .env.example .env
- в env:
    DB_CONNECTION=mysql
    DB_HOST=mysql-todo
    DB_PORT=3306
    DB_DATABASE=test
    DB_USERNAME=admin
    DB_PASSWORD=admin
- В терминале ./run
- ./cli key:generate
- ./cli migrate
- http://localhost:8000
- Готово)

## Если win без WSL
- в env:
  DB_CONNECTION=mysql
  DB_HOST=mysql-todo
  DB_PORT=3306
  DB_DATABASE=test
  DB_USERNAME=admin
  DB_PASSWORD=admin
- docker compose up -d --build
- docker exec php-todo php artisan key:generate
- docker exec php-todo php artisan migrate
