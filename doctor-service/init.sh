#!/bin/bash

symfony composer install --no-interaction
symfony console doctrine:migrations:migrate --no-interaction --allow-no-migration
symfony console doctor:import-medical-specialisations specialties.txt
symfony server:start
