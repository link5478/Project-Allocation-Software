<h1 align="center">
Project Allocation Software
</h1>

<p align="center">
<a href="https://travis-ci.org/link5478/Project-Allocation-Software"><img src="https://travis-ci.org/link5478/Project-Allocation-Software.svg?branch=master" alt="Build Status"></a>
</p>

## Requirements

PHP 7.0 and later  
Composer Package Manager  
NodeJS + npm  
MariaDB (or MySQL)

## Installation

1. Clone repository
1. Run `composer install`
1. Run `npm install`
1. Run `npm run dev`
1. Copy the `.env.example` to `.env` file, ensuring to put in your MariaDB details
1. Run `php artisan migrate`
1. Run `php artisan key:generate`
1. To Serve on local host: Run `php artisan serve`


## Test Login Details

Email: test@email.com
<br>
Password: password
