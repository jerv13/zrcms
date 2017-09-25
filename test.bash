#!/usr/bin/env bash

echo ""
echo "[test.bash] Running Composer install..."
composer self-update
composer --version
composer install --prefer-dist

echo ""
echo "[test.bash] Running PHP unit tests..."
php ./vendor/bin/phpunit

echo ""
echo "[test.bash] Running PHP Code Sniffer with fixer..."
php ./vendor/bin/phpcbf  -p --standard=PSR2 --ignore=vendor,test,config,data,autoload_classmap.php --extensions=php ./
#echo "[test.bash] Running PHP Code Sniffer..."
#php ./vendor/bin/phpcs  -p --standard=PSR2 --ignore=vendor,test,config,data,autoload_classmap.php --extensions=php ./
