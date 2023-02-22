<?php

if (!file_exists(__DIR__ . '/../.env')) {
    printf("Creating .env file from .env.example\n");
    copy(__DIR__ . '/../.env.example', __DIR__ . '/../.env');

    printf("Generating application key\n");
    exec("php artisan key:generate --ansi");
}

if (!file_exists(__DIR__ . '/../database/database.sqlite')) {
    printf("Creating database/database.sqlite file\n");
    touch(__DIR__ . '/../database/database.sqlite');
}
