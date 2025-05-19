composer i

cp .env.example .env

Edit the .env file with your database credentials, TELEGRAM_BOT_TOKEN and APP_URL with ngrok. (ngrok http 8000)

php artisan key:generate

php artisan migrate --seed

npm i && npm run dev

php artisan serve

ngrok http 8000

php artisan queue:work

php artisan app:set-telegram-webhook

php artisan test

php artisan app:notify-tasks

WITH DOCKER

docker compose up -d

docker exec -it php bash

composer install

cp .env.example .env

php artisan key:generate

Edit the .env file TELEGRAM_BOT_TOKEN and APP_URL with ngrok. (ngrok http 8000)
Example: APP_URL=https://5e51-46-250-1-182.ngrok-free.app

php artisan migrate --seed

php artisan queue:work > /dev/null 2>&1 & disown

php artisan app:set-telegram-webhook

php artisan app:notify-tasks
