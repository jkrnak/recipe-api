FROM php:7.1-apache

ENV COMPOSER_HOME /opt/composer
ENV PATH /opt/composer:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN apt-get update && apt-get install zip unzip -y && apt-get clean \
  && a2enmod rewrite \
  && mkdir -p /opt/composer \
  && curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
  && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
  && php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" \
  && php /tmp/composer-setup.php --install-dir=/opt/composer \
  && mv /opt/composer/composer.phar /opt/composer/composer \
  && chmod +x /opt/composer/composer

COPY config/apache2/000-default.conf /etc/apache2/sites-available/

COPY composer.* /var/www/html/

RUN composer install --no-autoloader --no-custom-installers --no-scripts --no-suggest \
  && composer clear-cache

COPY . /var/www/html

RUN mkdir -p bootstrap/cache \
  && chown -R www-data:www-data storage bootstrap/cache database \
  && composer install --no-suggest
