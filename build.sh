#!/bin/bash

# Install PHP dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies and build frontend
npm install
npm run build

# Clear and cache config/routes for production
php artisan config:clear
php artisan route:clear
php artisan view:clear
