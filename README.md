# Hexaland Slim 4 PHP api.

This application is built on top of Slim Framework. It has mysql, redis and php_myadmin setup.
Use this skeleton application to quickly setup and start working on a new Slim Framework 4 application. This application uses the latest Slim 4 with Slim PSR-7 implementation and PHP-DI container implementation. It also uses the Monolog logger.

Used phinx for running migrations.

## Install the Application

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writable.

To run the application in development, you can run these commands 

use `docker-compose` to run the app with `docker`, so you can run these commands:
```bash
cd hexaland
docker-compose up -d // To run in detached mode.
```

If running for the first time please run the following commands

Run Migrations
* If you have not already started, start docker containers by running
````
docker-compose up
````

* Run these command
````
docker-compose exec slim vendor/bin/phinx migrate
docker-compose exec slim vendor/bin/phinx seed:run -v
````

After that, open `http://localhost:8080` in your browser.

Run this command in the application directory to run the test suite
Tests are not yet implemented.
```bash
composer test
```

