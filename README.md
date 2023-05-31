## About the project

REST API - ecommerce flow

Technical info:

- Laravel v10.x
- PHP 8.1
- MySQL 8

Steps:

- Clone repository
- copy .env.example to .env
- run command: composer install
- run command: php artisan key:generate
- run command: php artisan migrate --seed
- import collection json file (Sell Products API.collection.json) to postman for endpoints
- import environment (for baseUrl and token) - environment.json

Seeder will create by default:

- admin user -> admin@ht.com and pass: password
- payment methods (Credit cards and paypal)
- 20 products with fake names and prices


### Simple Flow

- Register a new customer - Register endpoint
- Login with the new customer - GET auth token
- Copy token which placed in data parameter and paste it on token enviroment variable.
- GET id of my cart - Get my cart endpoint (get cart by token, so no parameters)
- GET products to get ID of product
- Add item to my cart - Create cart item endpoint (product id and quantity)
- GET my cart to see my cart updated 
- POST create payment (You can see an example body on postman)
- POST create order (cart id and payment id) this will copy cart content and paste it to the order
- UPDATE order with status PAID to finish the flow
