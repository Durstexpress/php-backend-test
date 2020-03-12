#!/bin/bash

set +ex

function installDevDependencies()
{
    echo "--- Installing dev dependencies ---"
    cd "$APP_DIR" || exit
    composer install --no-suggest
}

function migrateDatabase()
{
    echo "--- Migrating DB ---"
    cd "$APP_DIR" || exit
    composer run-script migrate
}

if [ "$1" = "test" ]; then
    installDevDependencies

    composer test || true

    exit $?
elif [ "$1" = "dev" ]; then
    installDevDependencies

    migrateDatabase

    php-fpm && nginx -g "daemon off;"
elif [ -z "$1" ]; then
    php-fpm && nginx -g "daemon off;"
else
    exec "$@"
fi
