RUN_ARGS := $(wordlist 2, $(words $(MAKECMDGOALS)), $(MAKECMDGOALS))
$(eval $(RUN_ARGS):;@true)

.RECIPEPREFIX := $(.RECIPEPREFIX) ''
.DEFAULT_GOAL := help

up:
   docker compose up -d

run:
   docker compose exec php bash -c "cd mip-core && $(RUN_ARGS)"

connect:
   docker compose exec php bash
