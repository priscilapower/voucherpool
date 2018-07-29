# VOUCHER POOL API

The application is an API which manipulate voucher codes, permitting you generate new codes, validate existing ones and list.

## Getting Started

For you can use the API, some steps are necessary to get start.
Follow the steps to make your API code usefully.

1- Create a database named **voucherspool** with your prefer client or using the terminal:

`mysql -u root -p`

`create database voucherspool;`

`exit;`

2- Set your mysql host, user and password on .env file.

3- Run the migrate in your root path to create the tables.

`php artisan migrate`

4- If you want, run the seeder to create fake data.

`php artisan db:seed`

5- Now it's just start the server.

`php -S localhost:8000 -t public`


## Documentation

Documentation for the API can be found on the [Postman Collection](https://documenter.getpostman.com/view/1464988/RWMLKkwh).
It will help you to understand how works the endpoints and what parameters are required.
Remember: the data on the examples are fake, your data must to be in your database to get the expects results.


Enjoy it !