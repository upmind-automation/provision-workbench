#! /bin/sh

cd /provision-workbench;

printf "Touching Logfile\n";
touch ./storage/logs/laravel.log && chmod 666 ./storage/logs/laravel.log;
printf "Installing dependencies\n";
/usr/local/bin/composer install --no-interaction --no-scripts
printf "Caching Config\n";
/usr/local/bin/php ./artisan config:cache > /dev/null
printf "Caching Routes\n";
/usr/local/bin/php ./artisan route:cache > /dev/null
printf "Caching Provision Registry\n";
/usr/local/bin/php ./artisan upmind:provision:cache

printf "Starting apache...\n\n";

/usr/sbin/apache2 -DFOREGROUND