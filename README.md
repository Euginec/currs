## INSTALL
```php
composer install
php artisan migrate
php artisan db:seed --class=ExchangeRateTableSeeder
php artisan key:generate
npm install
npm run dev
php artisan serve
```

сайт откроется по [ссылке](http://laravel::8000)
используется JWT авторизация

так же можно выставить cron на ежедневное обновление курса валют.

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

Cейчас время обновления 10 часов утра, если запись добавлена к cron.

## REST API
registration
```bash
curl --location --request POST 'localhost:8000/api/register' \
--header 'Accept: application/json' \
--form 'name=test' \
--form 'email=test@test.com' \
--form 'password=qqqqqq' \
--form 'password_confirmation=qqqqqq'
```

login
```bash
curl --location --request POST 'localhost:8000/api/login' \
--header 'Accept: application/json' \
--form 'email=test@test.com' \
--form 'password=qqqqqq'
```

get current reates
```bash
curl --location --request GET 'localhost:8000/api/rates/current' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer <ACCESS_TOKEN>'
```

get rates history
```bash
curl --location --request POST 'localhost:8000/api/rates/history' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer <ACCESS_TOKEN>' \
--form 'start=2020-05-24' \
--form 'end=2020-05-26'
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
