# MovieGame Project

A cinematographic culture test game.

## Purpose

Assess knowledge and practical application of [JavaScript ES6](https://262.ecma-international.org/6.0/) 
and [PHP 8.1](https://www.php.net/releases/8.1/en.php) programming languages and architectures 
with moderns frameworks such as [Symfony 5.4 LTS](https://symfony.com/releases) and [React 18.2](https://reactjs.org/versions/).

## Requirement

* [Docker Compose V2.10+](https://docs.docker.com/compose/compose-v2/)

The `compose` V2 command is a `docker` sub command.  
Basically, you can run Compose V2 using `docker compose`, instead of `docker-compose`.  

## Get started

1. Run `git clone git@github.com:ptim4x/MovieGame.git` to download this project.
2. Run `cd MovieGame` to change current directory.

### Next steps with make

3. Run `make install.prod` to build fresh Docker images and build front prod assets.
4. Run `make run` to start the Docker containers.
5. Run `make game.data setsize=100` to fetch TMDB API and generate 100 game question set.
6. Open [https://localhost:4443](https://localhost:4443) in your favorite web browser, [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334) and enjoy playing.
7. Run `make clean` to stop and remove the Docker containers.

### Next steps without make

3. Run `docker compose build --no-cache` to build fresh images.
4. Run `docker compose -f docker-compose.builder.yml run --rm install` to install node packages.
5. Run `docker compose -f docker-compose.builder.yml run --rm build` to build front assets.
6. Run `HTTP_PORT=8000 HTTPS_PORT=4443 docker compose up -d` to start the Docker containers.
7. Run `docker compose exec php php bin/console app:data:load 100 --themoviedb` to fetch TMDB API and generate 100 game question set.
8. Open [https://localhost:4443](https://localhost:4443) in your favorite web browser, [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334) and enjoy playing.
9. Run `docker compose down --remove-orphans` to stop and remove the Docker containers.

## Game play

### Rules

    Within a given time (60 seconds), the game has several rounds with an actor and a movie poster for each.
    The player must say if the actor played in the film presented or not.
    The game ends at the end of the allotted time or at the first error, and gives the score to the user.
    He has the possibility of replaying to try to beat his best score.

### Keyboard shortcut

* Play button : `Space` or `Enter`
* Answer buttons : `Left arrow` = Yes / `Right arrow` = No

## Utils

* PostgreSql Database : available on port 54321 in dev environement

* Run `docker-compose exec database psql -U meatloaf -d game -c "TRUNCATE TABLE question; TRUNCATE TABLE answer CASCADE; TRUNCATE TABLE answer CASCADE; TRUNCATE TABLE movie CASCADE;"` to truncate all tables.


## Credits

Made with love and sleepless nights by Maxime Brignon
