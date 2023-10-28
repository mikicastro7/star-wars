# Project Title
Symfony star wars application.

# Description
This Symfony application is a RUD that gets the data from an external API https://swapi.dev/api/

# Steps to follow to run the APP
1- Download the project from Github in your local

2- Run composer install

3- Configure the .env file or create a .env.local file it should have a db connection 

###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=9ea2d4b318f6ecc3131fb064ef9e886a
###< symfony/framework-bundle ###

###> doctrine/doctrine-bundle ###
DATABASE_URL=mysql://root@127.0.0.1:3306/star_wars
###< doctrine/doctrine-bundle ###

4- Run php bin/console doctrine:schema:update --force to create the databse structure. 

5- Import the data from the API wit the command by running: php bin/console starwars:import

6- Start the develoment server with command: symfony server:start

7- Enjoy star wars information. 