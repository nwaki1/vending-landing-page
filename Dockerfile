FROM serversideup/php:8.4-fpm-nginx

USER root

RUN mkdir -p /var/www/html/storage/tmp \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/sessions \
    /var/www/html/bootstrap/cache

COPY docker/entrypoint.d/99-laravel-permission.sh /etc/entrypoint.d/99-laravel-permission.sh

RUN chmod +x /etc/entrypoint.d/99-laravel-permission.sh

USER root
