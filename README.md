1 -  in which you can manage your assets and see values.

- You can create two entities in this API: User and Asset:
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
- Generate .env file using CML command >> php artisan key:generate.
- Database name variable should be like >> DB_DATABASE=crypto_task <<.
- This application use external API data, so you need to register to https://coinlayer.com/ and get your access KEY.
- In .env file create additional variable >> COIN_LAYER_API_KEY=****your key from coinlayer.com******.
- Make migrations using CML command >> sail artisan migrate <<.
- Seed database using CML command >> sail artisan db:seed <<.
- Go to http://localhost/login  and enjoy it :)
