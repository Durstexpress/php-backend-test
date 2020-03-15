FROM php:7.4-fpm-alpine

EXPOSE 80

RUN apk update
RUN apk add nginx bash openrc nano
RUN docker-php-ext-install \
    # DATABASE
	pdo pdo_mysql

# Installing composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php && mv composer.phar /usr/local/bin/composer

USER 1000
COPY . /var/www/html

USER root

# Configure Nginx
RUN mkdir -p /run/nginx

COPY docker/config/nginx/default.conf /etc/nginx/conf.d/default.conf

# Use the default production php configuration
RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf
RUN cp docker/config/php/php.ini "$PHP_INI_DIR/php.ini"
RUN cp docker/config/php/php-fpm.conf "/usr/local/etc/php-fpm.d/www.conf"

ADD docker/start.sh /
RUN chmod +x /start.sh

#RUN composer install --no-cache --prefer-dist --no-interaction

USER root

CMD ["/start.sh"]
