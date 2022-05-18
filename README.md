# Easy ecommerce
Light weight ecommerce built on laravel.

Admin built on inertia vue (vue 3) and front-end built on alpine js and blade template.

## Status
Currently this application is in development and unstable.

## Plan 
Our aim is to publish alpha version on 1st Oct 2022

## How to install
1. Create a fresh laravel app (Using docker recommended)
2. Create a new folder called package in the root directory
3. Clone this repository into that folder
4. Run below composer commands
   1. composer config repositories.multi-auth '{"type": "path", "url": "./package/easy/multi-auth"}' --file composer.json
   2. composer config repositories.ecommerce '{"type": "path", "url": "./package/easy/ecommerce"}' --file composer.json
   3. composer require
   4. Enter package name when prompted "Search for a package" easy/multi-auth and easy/ecommerce one by one.
5. Run Below artisan commands
   1. (php/sail) artisan easy:multi-auth
   2. (php/sail) artisan vendor:publish --tag=multi-auth --tag=ecommerce --force && sail npm run dev
   3. (php/sail) artisan migrate
6. Now run below command to create an admin user
   1. (php/sail) artisan easy:create-admin {name} {email} {password}

