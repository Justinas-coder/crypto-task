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
3. Create .env file
```
   cp .env.example .env
```
4. Install PHP dependencies (reference: https://laravel.com/docs/9.x/sail#installing-composer-dependencies-for-existing-projects)
```
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
5. Start containers
```
    ./vendor/bin/sail up -d
```
6. Generate app encryption key
```
./vendor/bin/sail artisan key:generate
```
7. Make migrations using CML command
```
./vendor/bin/sail artisan migrate
```
8. Seed database using CML command.
```
./vendor/bin/sail artisan db:seed
```
9. Application use external API https://coinlayer.com/ data, so you need to get you API KEY and create
variable in .env file as bellow:
```
COIN_LAYER_API_KEY="YOUR KEY"
```
10. Go to http://localhost/login  and enjoy it :)


### As HTTP API application returns JSON format.

#### URL: ```http://localhost/api/assets```  returns all created asset with values as e.g. :

- "id": 5
- "title": "Testing blach"
- "currency": "MIOTA"
- "quantity": "3"
- "payed_value": "3232"
- "current_value": 1.48593
- "created_at": "2022-05-06 07:07:41"

#### URL: http://localhost/api/assets/total returns total values of each currency, 
value is calculated with live data from external API. e.g :

- [
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
]

#### For asset "store"  use HTTP POST method with URL :

http://localhost/api/assets

API receives request with data as bellow e.g.

- 'user_id' => 'required|numeric',
- 'title' => 'required|min:8|max:255',
- 'crypto_currency' => ['required', Rule::in(['BTC', 'ETH', 'MIOTA'])],
- 'quantity' => 'required|numeric|min:0',
- 'paid_value' => 'required|numeric|min:0',
- 'currency' => 'required',

#### For asset "delete"  use HTTP DELETE method with URL :

http://localhost/api/assets

- Request should have asset "id" .

#### For asset "update"  use HTTP PUT method with URL :

http://localhost/api/assets/{id} 

End point of this URL is Asset id number.


#### Run PHP Unitest for Asset store and DB check for Web and Api applications with CML command 
```
./vendor/bin/sail artisan test
```

