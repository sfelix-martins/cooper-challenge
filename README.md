## CooperChallenge

A basic product order flow management system. 

## Pre-requisites

The Laravel framework has a few system requirements. All of these requirements are satisfied by the [Laravel Homestead](https://laravel.com/docs/5.8/homestead) virtual machine, so it's highly recommended that you use Homestead as your local Laravel development environment.

However, if you are not using Homestead, you will need to make sure your server meets the following requirements:

- PHP >= 7.1.3
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- MySql >= 5.7
- Composer

I recommend too the [Laradock](http://laradock.io/) to up your environment more easily.

## Installation

Clone the project and access the root folder:

```bash
git clone git@github.com:sfelix-martins/cooper-challenge.git
cd cooper-challenge
```

Install the dependencies using composer:

```bash
composer install
```

Copy the `.env.example` file to `.env` and set your database configs. E.g.:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cooperchallenge
DB_USERNAME=homestead
DB_PASSWORD=secret
```

Generate the application key:

```bash
php artisan key:generate
```

Finishing, with your database credentials defined on `.env` file, run the migrations:

```bash
php artisan migrate
```

Serve the application: 

```bash
php artisan serve
```

Ready! Now you are able to use the application features.

## Usage

The following instruction presumes that you are serving the application on address `http://localhost:8000`. 
If you are serving in a different host, just change it.  

### Products

Access the route `http://localhost:8000/products` in your browser and action to manage products will be shown.

### Orders 

Access the route `http://localhost:8000/orders` in your browser and action to manage orders will be shown.

## Unit Testing

### Pre-requisites

- [Sqlite3](https://www.sqlite.org/index.html)

### Running

On project root folder, just run the following command:

```bash
vendor/bin/phpunit
```









