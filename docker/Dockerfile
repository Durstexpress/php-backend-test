FROM php:7.4-fpm-alpine
LABEL maintainer="durstexpress"

ENV USER 1000
ENV COMPOSER_HOME $HOME/.composer

EXPOSE 80

# Install required dependencies
RUN apk --update add bash \
		     curl \
		     git \
		     nginx \
		     zip unzip \
		     openrc \
		     nano && rm /var/cache/apk/*

# Install required php extensions
RUN docker-php-ext-install pdo_mysql

# Install composer
RUN mkdir $COMPOSER_HOME && chown -R $USER $COMPOSER_HOME
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Configure nginx
RUN mkdir -p /run/nginx
COPY docker/config/nginx/default.conf /etc/nginx/conf.d/default.conf

USER $USER
# Add application files to docker
COPY . /var/www/html

USER root
# Use the default production php configuration
RUN \
  rm /usr/local/etc/php-fpm.d/zz-docker.conf && \
  cp docker/config/php/php.ini "$PHP_INI_DIR/php.ini" && \
  cp docker/config/php/php-fpm.conf "/usr/local/etc/php-fpm.d/www.conf"

ADD docker/start.sh /
RUN chmod +x /start.sh

CMD ["/start.sh"]
