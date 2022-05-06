1 -  Application can manage your your crypto assets and see values.

- You can create two entities in this Web Application: User and Asset:
- User can CRUD his Assets.

Asset:
- Has label e.g 'binance'.
- Currencies available: BTC, ETH, IOTA .
- Value cannot be negative.
- Application can have the same currency multiple times. e.g (1BTC 'usb stick', 1BTC 'binance'). Get the
  value of his Assets in USD (both total and separately).
- Application get exchange rate from external API.


Stack:

- Docker
- Laravel 9x
- Bootstrap



How to launch it:
- Deppending on your OS (win, Ubuntu, Mac) make your system ready to use (https://www.docker.com).
- Clone repository to the Docker container and run it.
- Install PHP dependencies: composer install.
- Generate .env file using CML command >> php artisan key:generate.
- Database name variable should be like >> DB_DATABASE=crypto_task <<.
- This application use external API data, so you need to register to https://coinlayer.com/ and get your access KEY.
- In .env file create additional variable >> COIN_LAYER_API_KEY=>>>your key from coinlayer.com<<<<.
- Make migrations using CML command >> sail artisan migrate <<.
- Seed database using CML command >> sail artisan db:seed <<.
- Go to http://localhost/login  and enjoy it :)

Run PHP Unitest for Asset store and DB check with CML command >> "sail artisan test".


As HTTP API application returns JSON format.

URL: http://localhost/api/assets  returns all created asset with values as e.g. :

"id": 5,
"title": "Testing blach",
"currency": "MIOTA",
"quantity": "3",
"payed_value": "3232",
"current_value": 1.48593,
"created_at": "2022-05-06 07:07:41"

URL: http://localhost/api/assets/total returns total values of each currency, 
value is calculated with data from external API. e.g :

[
{
"currency": "BTC",
"current_value": 2089086.5048939998
},
{
"currency": "ETH",
"current_value": 8069.964915
},
{
"currency": "MIOTA",
"current_value": 1.46922
}
]
