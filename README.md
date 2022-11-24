<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# SeamLabs Interview Test

## Test

```sh
sail artisan test
```

## Installation

```sh
# pull the repo
git pull https://github.com/IbrahimFathy19/seamlabs.git
# copy env file
cp .env.example .env
# run to make sail available in vendor as docker-compose depends on it
composer install
# generate new APP key
./vendor/bin/sail artisan key:generate
# start the server
./vendor/bin/sail up
# migrate database
./vendor/bin/sail artisan migrate
```

> Then you will be able to interact with the web application through ```http://localhost:8000```
