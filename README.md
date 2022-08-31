### Application can manage your your crypto assets and see values.

- You can create two entities in this Web Application: User and Asset:
- User can CRUD his Assets.

### Asset:
- Has label e.g 'binance'.
- Currencies available: BTC, ETH, IOTA .
- Value cannot be negative.
- Application can have the same currency multiple times. e.g (1BTC 'usb stick', 1BTC 'binance'). Get the
  value of his Assets in USD (both total and separately).
- Application get exchange rate from external API.


### Stack:

- Docker
- Laravel 9x
- Bootstrap
- Postman



### How to launch it:

1. Deppending on your OS (win, Ubuntu, Mac) make your system ready to use (https://www.docker.com).

2. Clone this repo
```
   git clone https://github.com/Justinas-coder/crypto-task
```
3. Install PHP dependencies (reference: https://laravel.com/docs/9.x/sail#installing-composer-dependencies-for-existing-projects)
```
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
4. Create .env file
```
   cp .env.example .env
```

5. Generate app encryption key
```
./vendor/bin/sail artisan key:generate
```

6. Start containers
```
    ./vendor/bin/sail up -d
```

7. Make migrations using CML command (Set the database connection in .env before migrating as bellow:

- DB_DATABASE=crypto_task
- DB_USERNAME=sail
- DB_PASSWORD=password

```
./vendor/bin/sail artisan migrate
```
8. Seed database using CML command.
```
./vendor/bin/sail artisan db:seed
```
9. Application use external API https://coinlayer.com/ data, so you need to get you API KEY and create
fill in .env variable, as bellow:
```
COIN_LAYER_API_KEY="YOUR KEY = Your Key."
```
10. You can now access the server at http://localhost/login  


### As HTTP API application returns JSON format.

#### URL: 
```
http://localhost/api/assets
```  
returns all created asset with values in JSON data format as e.g. :

"asset": {
    "id": 3,
    "user_id": 1,
    "title": "Testing Jason 3",
    "crypto_currency": "BTC",
    "quantity": "2",
    "paid_value": "32",
    "currency": "USD",
    "created_at": "2022-08-24T13:12:32.000000Z",
    "updated_at": "2022-08-26T07:23:54.000000Z"
}

#### URL: 
```
http://localhost/api/assets/total
```
returns total values of each currency, 
value is calculated with live data from external API. e.g :

{
"currency": "BTC",
"current_value": 2089086.5048939998
},
- {
"currency": "ETH",
"current_value": 8069.964915
},
- {
"currency": "MIOTA",
"current_value": 1.46922
}


#### For asset "store"  use HTTP POST method with URL :

```
http://localhost/api/assets
```

API receives request with JSON data as bellow e.g.

{
"title": "Testing Jason POST",
"crypto_currency": "BTC",
"quantity": "2",
"paid_value": "32",
"currency": "USD"
}

#### For asset "delete"  use HTTP DELETE method with URL :

```
http://localhost/api/assets
```

- Request should have asset "id" .

#### For asset "update"  use HTTP PUT method with URL :

```
http://localhost/api/assets/{id}
``` 

End point of this URL is Asset id number.


#### Run PHP Unitest for Asset store and DB check for Web and Api applications with CML command 
```
./vendor/bin/sail artisan test
```

END

