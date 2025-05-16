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
