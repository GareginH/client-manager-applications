
# Client Manager Support System.

## Как начать использовать
    - Git clone https://github.com/GareginH/client-manager-applications.git
    - composer install
    - npm i
    - копируем .env.example и переименовываем в .env
        - в .env добавляем информацию о своей базе данных (DB_), емейл провайдера(MAIL_).
    - php artisan key:generate
    - php artisan storage:link
    - php artisan migrate --seed
    
## How to use this
    - Git clone https://github.com/GareginH/client-manager-applications.git
    - composer install
    - npm i
    - copy .env.example and rename it to .env
        -in .env add your database(DB_) and mail(MAIL_) info
    - php artisan key:generate
    - php artisan storage:link
    - php artisan migrate --seed
