# Laravel Todo List

Simple Todo List Application.

Try using email "farhan@gmail.com" and password "secret".

## Installation

Please check the official Laravel 5.2 installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.2)

Clone the repository

    git clone git@github.com:mfarhanf/laravel_todolist.git

Switch to the repo folder

    cd laravel_todolist

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate key

    php artisan key:generate

Run database migration

    php artisan migrate

Run database seeder

    php artisan db:seed

**TL;DR command list**

    git clone git@github.com:mfarhanf/laravel_todolist.git
    cd laravel_todolist
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan db:seed

## Run The Application

Run Your server

    php artisan serve

Go to Login Page

    http://localhost:8000/login

Go to Home

    http://localhost:8000/home

## UnitTest

Install sqlite

    apt-get install sqlite3 libsqlite3-dev

Run unit test

    vendor/bin/phpunit
