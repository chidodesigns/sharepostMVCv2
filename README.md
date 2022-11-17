# Sharepost App


A custom PHP MVC designed Application, that enables you to:

1. Create A User
2. User Login
2. Create A Post 
3. See All Posts
3. User Logout


---


## About The App
The application is built in a Model View Controller pattern to resemble php frameworks like Laravel and Symfony. 

The decision to build this application in raw PHP is because we are using an ORM wrapper in the form of j4mie/idiorm. 

This package is shipped with all the latest Laravel versions and the ORM package informs you to use Laravel Eloquent Model instead. Whilst the Symfony framework comes with Doctrine, so I thought it best to keep the same spirit of a framework and use the abstract ORM with it. 

The MVC itself is extensible and the Sharepost functionality is built on top the core MVC. 

- You can find the core framework in side the `./core` directory.
- Update MVC Routing Routes: `./config/routes/routes.php`.


### App Images
- Images are stored publicly and are also available to the public as a folder on the server. 
- Image Maximum Size is 1mb within this MVC so you must upload compressed images.
- Images are stored directly on the host machine/server once uploaded from client.


## Set Up 
- This is application is best run with Docker, it will enable you to skip manually setting up a DB and server. 
- If you do not have Docker running on your machine, you can simply set up a LAMP stack server on your machine as the first step before running the App.
- run `composer install` [when the docker container is run this cmd will also run / we run it locally to ensure all composer packages are downloaded]
- run `composer dump-autoload` [Have all namespace classes loaded]
- create a `.env` [this has been gitignored] - Docker Database Container Env's also run off this .env file  - You can copy the below variables and modify as you see fit. 
DOCKER
- `setup.sql` is a file that will run when docker starts to build the containers -  this file creates the tables automatically as part of the docker container build process. 
- Use a DB Management Tool like TablePlus to have a visual representation and interact with the DB and its stucture. 
- With Docker running in the background run `docker-compose up --build` this will start the container build process. Once complete you can access the live server at `http://localhost:8080`. 
- `./screenshot.png` is a snapshot of the homepage.


## ENV Variables

.env file example: 


DB_HOST=mariadb

DB_USER=setauser

DB_PASSWORD=setapassword

DB_NAME=shareposts

DB_CHARSET=utf8mb4

APPNAME=shareposts

APP_SECRET=f544a396f51577d59f91611fdcd1852c

APPVERSION=1.0.0

APP_URL=http://localhost:8080

APP_DEBUG=true


## Testing Suite
- Run `./vendor/bin/phpunit` to run the test suite, this action should be performed after composer is installed.
- Test suite coverage is an WIP: Missing Integration Testing (For Controllers).


## Docker Container (LAMP Stack)
This application is wrapped within a docker container:

1. PHP-APACHE image 
2. MariaDB image

