# MovieGame Project

A cinematographic culture test game.

## Purpose

Assess knowledge and practical application of [JavaScript ES6](https://262.ecma-international.org/6.0/) 
and [PHP 8.1](https://www.php.net/releases/8.1/en.php) programming languages and architectures 
with moderns frameworks such as [Symfony 5.4 LTS](https://symfony.com/releases) and [React 18.2](https://reactjs.org/versions/).

## Requirement

* [Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)

## Get started

### with make

1. Run `make install.prod` to build fresh Docker images and build front prod assets.
1. Run `make run` to start the Docker containers.
1. Run `make setsize=100 game.data` to fetch TMDB API and generate 100 game question set.
5. Open [https://localhost:4443](https://localhost:4443) in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334) and enjoy playing.
6. Run `make clean` to stop and remove the Docker containers.

### without make

1. Run `docker compose build --no-cache` to build fresh images.
2. Run `HTTP_PORT=8000 HTTPS_PORT=4443 docker compose up -d` to start the Docker containers.
3. Run `docker compose -f docker-compose.builder.yml run --rm install` to install node packages.
3. Run `docker compose -f docker-compose.builder.yml run --rm build` to build front assets.
4. Run `docker compose exec php php bin/console app:data:load 100 --themoviedb` to fetch TMDB API and generate 100 game question set.
5. Open [https://localhost:4443](https://localhost:4443) in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334) and enjoy playing.
6. Run `docker compose down --remove-orphans` to stop and remove the Docker containers.

## Game play

### Rules

    Within a given time (60 seconds), the game has several rounds with an actor and a movie poster for each.
    The player must say if the actor played in the film presented or not.
    The game ends at the end of the allotted time or at the first error, and gives the score to the user.
    He has the possibility of replaying to try to beat his best score.

### Keyboard shortcut

* Play button : `Space` or `Enter`
* Answer buttons : `left arrow` = Yes / `right arrow` = No

## Utils

* PostgreSql Database : available on port 54321 in dev environement

* Run `docker-compose exec database psql -U meatloaf -d game -c "TRUNCATE TABLE question; TRUNCATE TABLE answer CASCADE; TRUNCATE TABLE answer CASCADE; TRUNCATE TABLE movie CASCADE;"` to truncate all tables.


## Credits

Made with love and sleepless nights by Maxime Brignon
