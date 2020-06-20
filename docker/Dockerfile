FROM benpoulson/laravel-alpine:latest
MAINTAINER Ben Poulson <benpoulson@protonmail.ch>
WORKDIR /var/www/html/
EXPOSE 80

COPY --chown=www-data:www-data . /var/www/html/
RUN composer install
CMD /wait && php /var/www/html/artisan migrate && /usr/bin/supervisord -n -c /etc/supervisord.conf
