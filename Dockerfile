################################################################################
### Backend Base System Image                                                ###
################################################################################
FROM php:7.4-fpm-alpine as base-backend-system
LABEL application_name="php-backend-test"

# Default ennvironment
ENV APP_DIR /var/www/html
ENV APP_ENV prod
ENV APP_DEBUG 0
ENV COMPOSER_HOME /.composer

# Install debian packages usefull
RUN apk update
RUN apk add nginx bash openrc nano
RUN docker-php-ext-install pdo_mysql

# Configure Nginx
RUN mkdir -p /run/nginx
COPY docker/config/nginx/default.conf /etc/nginx/conf.d/default.conf

# Use the default production php configuration
RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf
COPY docker/config/php/php.ini "$PHP_INI_DIR/php.ini"
COPY docker/config/php/php-fpm.conf "/usr/local/etc/php-fpm.d/www.conf"

# Install dependencies
RUN mkdir $COMPOSER_HOME && chmod -R 777 $COMPOSER_HOME

COPY --from=composer:1.8 /usr/bin/composer /usr/bin/composer

################################################################################
### Backend Base Image                                                       ###
################################################################################
FROM base-backend-system as base-backend
LABEL application_name="php-backend-test"

USER 1000

COPY . $APP_DIR

RUN COMPOSER_MEMORY_LIMIT=-1 \
    composer install --no-autoloader --no-scripts --no-progress --no-suggest

USER root

EXPOSE 80

ADD docker/start.sh /
RUN chmod +x /start.sh

ENTRYPOINT ["/start.sh"]
