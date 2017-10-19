#!/bin/sh
cd ~/workspace && git pull && composer update && php artisan migrate