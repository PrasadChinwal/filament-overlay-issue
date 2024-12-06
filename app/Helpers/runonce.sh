#!/bin/bash

ip_addr=$(ip addr show eth0 | awk '/inet / {print $2}' | awk -F "/" '{print $1}')
echo "$ip_addr  $DOCKER_SERVER" >> /etc/hosts

npm install
npm run build
php /var/www/laravel/artisan filament:assets

php artisan optimize:clear
php artisan icons:cache
php artisan event:cache
php artisan optimize

\cp /var/www/laravel/config/supervisord/queue.txt /etc/supervisor.d/queue.ini
\cp /var/www/laravel/config/nginx/default.txt /etc/nginx/default.tmpl

\cp /var/www/laravel/.vimrc /root/
curl -fLo ~/.vim/autoload/plug.vim --create-dirs https://raw.githubusercontent.com/junegunn/vim-plug/master/plug.vim

vim +'PlugInstall --sync' +qa

