UID ?= $(shell id -u)
GID ?= $(shell id -g)

install:
	# Hint: force a rebuild by passing --no-cache
	@UID=$(UID) GID=$(GID) docker-compose build --no-cache app
.PHONY: install-web

start:
	@UID=$(UID) GID=$(GID) docker-compose up -d --remove-orphans app
.PHONY: start

stop:
	@UID=$(UID) GID=$(GID) docker-compose stop
.PHONY: stop

tests:
	@UID=$(UID) GID=$(GID) docker-compose run --rm app test
.PHONY: php-tests

shell:
	# Hint: adjust UID and GID to 0 if you want to use the shell as root
	@UID=$(UID) GID=$(GID) docker-compose run --rm -w /var/www/html -e SHELL_VERBOSITY=1 app bash
.PHONY: shell

watch-logs:
	@UID=$(UID) GID=$(GID) docker-compose logs -f -t
.PHONY: watch-logs

clean:
	docker system prune -f --volumes --filter "label=application_name=php-backend-test" || true
	docker image prune -f -a --filter "label=application_name=php-backend-test" || true
.PHONY: clean
