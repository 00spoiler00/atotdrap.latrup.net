#!/bin/bash
git pull && composer install && npm i && npm run build && php artisan migrate && php artisan config:cache