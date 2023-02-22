#! /bin/sh

cd /provision-workbench;

printf "Touching Logfile\n";
touch ./storage/logs/laravel.log && chmod 666 ./storage/logs/laravel.log;
printf "Installing Dependencies\n";
/usr/local/bin/composer install --no-interaction --no-scripts
printf "Running install.php\n";
/usr/local/bin/php docker/install.php
printf "Caching Config\n";
/usr/local/bin/php ./artisan config:cache > /dev/null
printf "Caching Routes\n";
/usr/local/bin/php ./artisan route:cache > /dev/null
printf "Caching Provision Registry\n";
/usr/local/bin/php ./artisan upmind:provision:cache
printf "Running Migrations\n";
/usr/local/bin/php ./artisan migrate --force

printf "\nStarting apache on http://127.0.0.1:8000 ...\n\n";

/usr/sbin/apache2 -DFOREGROUND