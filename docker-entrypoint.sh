#!/bin/bash

php artisan config:clear
php artisan migrate --force

exec apache2-foreground
