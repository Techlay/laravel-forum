# Laravel Forum App

This is a demo app to showcase how a basic forum powered by Laravel framework can be built. I've used Vue.js as the frontend framework but the code should be easily portable to any other frontend frameworks.

This demo app is currently hosted on Digitalocean using LEMP stack: [forum.lytechlay.com](http://forum.lytechlay.com)

## Basic Installation Instructions

### Prerequisites

* To run this project, you must have PHP 7 installed.
* You should setup a host on your web server for your local domain. This demo assumes you are serving this Laravel app via Valet.

- Clone Repository
- Install PHP Dependencies: `composer install`
- Install Frontend Dependencies: `npm install`
- Compile Dependencies: `npm run dev`
- Create .env file: `cp .env.example .env`
- Generate APP_KEY: `php artisan key:generate`
- Migrate Database: `php artisan migrate`

Next, boot up a server and visit your forum. If using a tool like Laravel Valet, the URL will default to `http://forum.test`.

### Tricks

To test application the database is seeding with user:

* Administrator : email = john@example.com, password = administrator