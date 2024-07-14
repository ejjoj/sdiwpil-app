#!/bin/bash

symfony composer install --no-interaction
symfony console doctrine:migrations:migrate --no-interaction --allow-no-migration
symfony server:start
