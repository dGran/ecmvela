RUN_ARGS := $(wordlist 2, $(words $(MAKECMDGOALS)), $(MAKECMDGOALS))
$(eval $(RUN_ARGS):;@true)

.RECIPEPREFIX := $(.RECIPEPREFIX) ''
.DEFAULT_GOAL := help

up:
    docker compose up -d

up-clean:
    docker compose up -d --remove-orphans --build --force-recreate

connect:
    docker compose exec php bash

stop:
    docker compose stop