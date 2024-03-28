@echo off
echo Installando dependencias do composer...
composer install

echo Rodando migrações do database...
php artisan migrate

echo gerando chave de aplicativo
php artisan key:generate
