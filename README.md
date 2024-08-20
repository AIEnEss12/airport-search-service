# airport-search-service
Тестовое задание (поиск аэропорта)



для запуска:
1. docker compose up -d - запуск docker/билд контейнеров
2. зайти в образ php-8.2: docker compose exec php-8.2 sh
3. Создать индекс - php artisan app:init-elastic-index-config
4. Записать из файла в индекс - php artisan elasticsearch:import-json

Пример - запроса
http://127.0.0.1/api/v1/search?query=test
