#!/bin/bash

echo "#######################################"
echo "### Laravel Development Environment ###"
echo "########################################"

cd /home/laravel/app


# Composer build
if [ ! -d vendor ]; then
    composer install
fi

# .env file set up
if [ ! -f .env ]; then
    cp .env.development .env
    php artisan key:generate --force
fi

# NPM build
if [ ! -d node_modules ]; then
    npm install
    npm run build
fi

# Storage symlink
php artisan storage:link

# Permissions
chmod 775 storage/framework
chmod 775 storage/logs
chmod 775 bootstrap/cache
chown -R ${UID}:${GID} /home/laravel/app
chmod +x artisan

echo "Entrypoint complete."

exec $@
