install.back:
	docker compose build --no-cache 

install.front:
	docker compose -f docker-compose.builder.yml run --rm install

assets.dev:
	docker compose -f docker-compose.builder.yml run --rm dev

assets.watch:
	docker compose -f docker-compose.builder.yml run --rm watch

assets.prod:
	docker compose -f docker-compose.builder.yml run --rm build

run:
	HTTP_PORT=8000 HTTPS_PORT=4443 docker compose up -d

stop:
	docker compose stop

game.data:
	docker compose exec php php bin/console app:data:load $(setsize) --themoviedb

clean:
	docker compose down --remove-orphans

install: install.back install.front
install.dev: install assets.dev
install.watch: install assets.watch
install.prod: install assets.prod